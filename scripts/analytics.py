#!/usr/bin/env python3
"""
VuxShop Data Analytics Engine
Phân tích dữ liệu đơn hàng, sản phẩm, doanh thu từ SQLite
"""

import sqlite3
import json
import sys
import os
from datetime import datetime, timedelta
from collections import defaultdict


def get_db_path():
    """Tìm đường dẫn SQLite từ argument hoặc mặc định."""
    if len(sys.argv) > 1:
        return sys.argv[1]
    # Default path relative to script location (Laravel root)
    script_dir = os.path.dirname(os.path.abspath(__file__))
    return os.path.join(script_dir, '..', 'database', 'database.sqlite')


def analyze(db_path: str) -> dict:
    conn = sqlite3.connect(db_path)
    conn.row_factory = sqlite3.Row
    c = conn.cursor()

    result = {}

    # ── 1. TỔNG QUAN ─────────────────────────────────────────────────────────
    c.execute("SELECT COUNT(*) as cnt FROM orders")
    total_orders = c.fetchone()['cnt']

    c.execute("SELECT SUM(total_price) as rev FROM orders WHERE status != 'cancelled'")
    row = c.fetchone()
    total_revenue = float(row['rev'] or 0)

    c.execute("SELECT COUNT(*) as cnt FROM orders WHERE status = 'pending'")
    pending_orders = c.fetchone()['cnt']

    c.execute("SELECT COUNT(*) as cnt FROM products WHERE is_active = 1")
    active_products = c.fetchone()['cnt']

    c.execute("SELECT COUNT(*) as cnt FROM users")
    total_users = c.fetchone()['cnt']

    result['overview'] = {
        'total_orders': total_orders,
        'total_revenue': total_revenue,
        'pending_orders': pending_orders,
        'active_products': active_products,
        'total_users': total_users,
        'avg_order_value': round(total_revenue / total_orders, 0) if total_orders > 0 else 0,
    }

    # ── 2. DOANH THU 30 NGÀY QUA (theo ngày) ──────────────────────────────────
    c.execute("""
        SELECT DATE(created_at) as day, SUM(total_price) as revenue, COUNT(*) as orders
        FROM orders
        WHERE status != 'cancelled'
          AND created_at >= DATE('now', '-30 days')
        GROUP BY DATE(created_at)
        ORDER BY day ASC
    """)
    rows = c.fetchall()

    # Fill missing days with 0
    revenue_by_day = {}
    for row in rows:
        revenue_by_day[row['day']] = {'revenue': float(row['revenue'] or 0), 'orders': row['orders']}

    daily_revenue = []
    for i in range(30):
        day = (datetime.now() - timedelta(days=29 - i)).strftime('%Y-%m-%d')
        daily_revenue.append({
            'date': day,
            'revenue': revenue_by_day.get(day, {}).get('revenue', 0),
            'orders': revenue_by_day.get(day, {}).get('orders', 0),
        })

    result['daily_revenue'] = daily_revenue

    # ── 3. TOP 10 SẢN PHẨM BÁN CHẠY ─────────────────────────────────────────
    c.execute("""
        SELECT p.name, p.price, SUM(oi.quantity) as total_sold,
               SUM(oi.quantity * oi.price) as revenue
        FROM order_items oi
        JOIN products p ON p.id = oi.product_id
        JOIN orders o ON o.id = oi.order_id
        WHERE o.status != 'cancelled'
        GROUP BY oi.product_id
        ORDER BY total_sold DESC
        LIMIT 10
    """)
    result['top_products'] = [
        {
            'name': row['name'],
            'price': float(row['price']),
            'total_sold': row['total_sold'],
            'revenue': float(row['revenue']),
        }
        for row in c.fetchall()
    ]

    # ── 4. PHÂN BỔ TRẠNG THÁI ĐƠN HÀNG ──────────────────────────────────────
    c.execute("""
        SELECT status, COUNT(*) as cnt
        FROM orders
        GROUP BY status
        ORDER BY cnt DESC
    """)
    result['order_status'] = [
        {'status': row['status'], 'count': row['cnt']}
        for row in c.fetchall()
    ]

    # ── 5. DOANH THU THEO DANH MỤC ───────────────────────────────────────────
    c.execute("""
        SELECT cat.name as category, SUM(oi.quantity * oi.price) as revenue,
               SUM(oi.quantity) as units
        FROM order_items oi
        JOIN products p ON p.id = oi.product_id
        JOIN categories cat ON cat.id = p.category_id
        JOIN orders o ON o.id = oi.order_id
        WHERE o.status != 'cancelled'
        GROUP BY cat.id
        ORDER BY revenue DESC
    """)
    result['revenue_by_category'] = [
        {'category': row['category'], 'revenue': float(row['revenue']), 'units': row['units']}
        for row in c.fetchall()
    ]

    # ── 6. SẢN PHẨM TỒN KHO THẤP (< 10) ─────────────────────────────────────
    c.execute("""
        SELECT name, stock, price
        FROM products
        WHERE is_active = 1 AND stock < 10
        ORDER BY stock ASC
        LIMIT 10
    """)
    result['low_stock'] = [
        {'name': row['name'], 'stock': row['stock'], 'price': float(row['price'])}
        for row in c.fetchall()
    ]

    # ── 7. TĂNG TRƯỞNG THÁNG NÀY VS THÁNG TRƯỚC ─────────────────────────────
    c.execute("""
        SELECT
            SUM(CASE WHEN strftime('%Y-%m', created_at) = strftime('%Y-%m', 'now') THEN total_price ELSE 0 END) as this_month,
            SUM(CASE WHEN strftime('%Y-%m', created_at) = strftime('%Y-%m', 'now', '-1 month') THEN total_price ELSE 0 END) as last_month,
            COUNT(CASE WHEN strftime('%Y-%m', created_at) = strftime('%Y-%m', 'now') THEN 1 END) as orders_this_month,
            COUNT(CASE WHEN strftime('%Y-%m', created_at) = strftime('%Y-%m', 'now', '-1 month') THEN 1 END) as orders_last_month
        FROM orders
        WHERE status != 'cancelled'
    """)
    row = c.fetchone()
    this_month = float(row['this_month'] or 0)
    last_month = float(row['last_month'] or 0)
    growth = ((this_month - last_month) / last_month * 100) if last_month > 0 else 0

    result['growth'] = {
        'this_month_revenue': this_month,
        'last_month_revenue': last_month,
        'revenue_growth_pct': round(growth, 1),
        'orders_this_month': row['orders_this_month'] or 0,
        'orders_last_month': row['orders_last_month'] or 0,
    }

    conn.close()
    result['generated_at'] = datetime.now().isoformat()
    return result


if __name__ == '__main__':
    db_path = get_db_path()
    try:
        data = analyze(db_path)
        print(json.dumps(data, ensure_ascii=False, indent=2))
    except Exception as e:
        error = {'error': str(e), 'generated_at': datetime.now().isoformat()}
        print(json.dumps(error))
        sys.exit(1)
