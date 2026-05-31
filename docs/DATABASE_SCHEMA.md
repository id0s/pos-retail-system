# Database Schema - POS Retail Management System

## Daftar Tabel (27 Tabel)

1. users
2. stores
3. categories
4. products
5. product_units
6. stocks
7. stock_movements
8. stock_opnames
9. stock_opname_details
10. stock_transfers
11. stock_transfer_details
12. suppliers
13. purchase_orders
14. purchase_order_details
15. members
16. transactions
17. transaction_details
18. payments
19. shifts
20. attendances
21. promotions
22. promotion_products
23. promotion_categories
24. vouchers
25. member_points
26. recipes
27. settings

## Struktur Tabel Detail

### 1. Users Table
```sql
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  username VARCHAR(50) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('super_admin', 'admin_cabang', 'kasir') NOT NULL,
  store_id INT,
  status TINYINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (store_id) REFERENCES stores(id),
  INDEX idx_username (username),
  INDEX idx_email (email)
);
```

### 2. Stores Table
```sql
CREATE TABLE stores (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  address TEXT,
  phone VARCHAR(20),
  tax DECIMAL(5,2) DEFAULT 10.00,
  service_charge DECIMAL(5,2) DEFAULT 0,
  status TINYINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 3. Categories Table
```sql
CREATE TABLE categories (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL UNIQUE,
  description TEXT,
  status TINYINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 4. Products Table
```sql
CREATE TABLE products (
  id INT PRIMARY KEY AUTO_INCREMENT,
  category_id INT NOT NULL,
  supplier_id INT,
  name VARCHAR(150) NOT NULL,
  sku VARCHAR(50) UNIQUE,
  barcode VARCHAR(50) UNIQUE,
  purchase_price DECIMAL(12,2),
  selling_price DECIMAL(12,2) NOT NULL,
  image VARCHAR(255),
  minimum_stock INT DEFAULT 0,
  status TINYINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id),
  FOREIGN KEY (supplier_id) REFERENCES suppliers(id),
  INDEX idx_sku (sku),
  INDEX idx_barcode (barcode)
);
```

### 5. Product Units Table
```sql
CREATE TABLE product_units (
  id INT PRIMARY KEY AUTO_INCREMENT,
  product_id INT NOT NULL,
  unit_name VARCHAR(50) NOT NULL,
  conversion_value INT NOT NULL,
  price DECIMAL(12,2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  UNIQUE KEY unique_product_unit (product_id, unit_name)
);
```

### 6. Stocks Table
```sql
CREATE TABLE stocks (
  id INT PRIMARY KEY AUTO_INCREMENT,
  product_id INT NOT NULL,
  store_id INT NOT NULL,
  qty INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id),
  FOREIGN KEY (store_id) REFERENCES stores(id),
  UNIQUE KEY unique_product_store (product_id, store_id)
);
```

### 7. Stock Movements Table
```sql
CREATE TABLE stock_movements (
  id INT PRIMARY KEY AUTO_INCREMENT,
  product_id INT NOT NULL,
  store_id INT NOT NULL,
  type ENUM('in', 'out', 'adjustment') NOT NULL,
  qty INT NOT NULL,
  reference VARCHAR(100),
  note TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id),
  FOREIGN KEY (store_id) REFERENCES stores(id),
  INDEX idx_type (type),
  INDEX idx_reference (reference),
  INDEX idx_created (created_at)
);
```

### 8. Suppliers Table
```sql
CREATE TABLE suppliers (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  phone VARCHAR(20),
  email VARCHAR(100),
  address TEXT,
  status TINYINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 9. Transactions Table
```sql
CREATE TABLE transactions (
  id INT PRIMARY KEY AUTO_INCREMENT,
  invoice_number VARCHAR(50) UNIQUE NOT NULL,
  store_id INT NOT NULL,
  cashier_id INT NOT NULL,
  member_id INT,
  shift_id INT,
  subtotal DECIMAL(12,2) NOT NULL,
  discount DECIMAL(12,2) DEFAULT 0,
  tax DECIMAL(12,2) DEFAULT 0,
  service_charge DECIMAL(12,2) DEFAULT 0,
  grand_total DECIMAL(12,2) NOT NULL,
  paid_amount DECIMAL(12,2),
  change_amount DECIMAL(12,2),
  payment_method ENUM('cash', 'qris', 'card') NOT NULL,
  payment_status ENUM('pending', 'success', 'failed') DEFAULT 'pending',
  status ENUM('completed', 'voided', 'refunded') DEFAULT 'completed',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (store_id) REFERENCES stores(id),
  FOREIGN KEY (cashier_id) REFERENCES users(id),
  FOREIGN KEY (member_id) REFERENCES members(id),
  FOREIGN KEY (shift_id) REFERENCES shifts(id),
  INDEX idx_invoice (invoice_number),
  INDEX idx_created (created_at)
);
```

### 10. Transaction Details Table
```sql
CREATE TABLE transaction_details (
  id INT PRIMARY KEY AUTO_INCREMENT,
  transaction_id INT NOT NULL,
  product_id INT NOT NULL,
  product_name VARCHAR(150),
  qty INT NOT NULL,
  unit VARCHAR(50),
  price DECIMAL(12,2) NOT NULL,
  discount DECIMAL(12,2) DEFAULT 0,
  subtotal DECIMAL(12,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id)
);
```

### 11. Members Table
```sql
CREATE TABLE members (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  phone VARCHAR(20) UNIQUE NOT NULL,
  email VARCHAR(100),
  address TEXT,
  tier ENUM('bronze', 'silver', 'gold') DEFAULT 'bronze',
  points INT DEFAULT 0,
  total_spent DECIMAL(12,2) DEFAULT 0,
  status TINYINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_phone (phone)
);
```

### 12. Shifts Table
```sql
CREATE TABLE shifts (
  id INT PRIMARY KEY AUTO_INCREMENT,
  store_id INT NOT NULL,
  cashier_id INT NOT NULL,
  opening_cash DECIMAL(12,2) NOT NULL,
  closing_cash_system DECIMAL(12,2),
  closing_cash_actual DECIMAL(12,2),
  difference DECIMAL(12,2),
  status ENUM('open', 'closed') DEFAULT 'open',
  opened_at TIMESTAMP,
  closed_at TIMESTAMP,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (store_id) REFERENCES stores(id),
  FOREIGN KEY (cashier_id) REFERENCES users(id),
  INDEX idx_status (status)
);
```

### 13. Promotions Table
```sql
CREATE TABLE promotions (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(150) NOT NULL,
  type ENUM('percentage', 'nominal', 'bogo', 'bundle', 'tiered') NOT NULL,
  discount_type VARCHAR(50),
  discount_value DECIMAL(12,2) NOT NULL,
  minimum_purchase DECIMAL(12,2),
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  start_time TIME,
  end_time TIME,
  days VARCHAR(100),
  member_only TINYINT DEFAULT 0,
  status TINYINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_status (status),
  INDEX idx_dates (start_date, end_date)
);
```

### 14. Vouchers Table
```sql
CREATE TABLE vouchers (
  id INT PRIMARY KEY AUTO_INCREMENT,
  code VARCHAR(50) UNIQUE NOT NULL,
  discount_type ENUM('percentage', 'nominal') NOT NULL,
  discount_value DECIMAL(12,2) NOT NULL,
  minimum_purchase DECIMAL(12,2),
  usage_limit INT,
  used_count INT DEFAULT 0,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  status TINYINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_code (code),
  INDEX idx_status (status)
);
```

## Skema Lengkap SQL

Untuk script SQL lengkap semua 27 tabel, silakan lihat file `docs/FULL_SCHEMA.sql`
