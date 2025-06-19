# Database Schema & Seeders Documentation

## 📋 Overview

This document provides a comprehensive explanation of the database structure, migrations, seeders, and table relationships for the **Donasi Barang Bekas (Berkah BaBe)** platform.

---

## 🗂️ Database Tables Overview

The platform uses **6 main tables** to manage users, donations, organizations, and requests:

1. **`users`** - Core user authentication and role management
2. **`organization_details`** - Extended information for organization users
3. **`donations`** - Donation items (goods and money)
4. **`donation_requests`** - Requests made by organizations
5. **`password_reset_tokens`** - Password reset functionality
6. **`sessions`** - User session management

---

## 📊 Table Structure & Relationships

### 1. Users Table (`users`)

**Purpose**: Core table for all users (Admin, Donatur, Organisasi)

**Migration File**: `0001_01_01_000000_create_users_table.php`

#### Schema:
```sql
CREATE TABLE users (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    role ENUM('donatur', 'organisasi', 'admin') DEFAULT 'donatur',
    is_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

#### Key Fields:
- **`role`**: Determines user type and dashboard access
  - `donatur`: Can create donations, browse organizations
  - `organisasi`: Can claim donations, create requests
  - `admin`: Can manage all users and donations
- **`is_verified`**: Additional verification flag (separate from email verification)
- **`email_verified_at`**: Laravel's built-in email verification

---

### 2. Organization Details Table (`organization_details`)

**Purpose**: Extended profile information for organization users

**Migration File**: `2025_06_05_180904_create_organization_details_table.php`

#### Schema:
```sql
CREATE TABLE organization_details (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNIQUE NOT NULL,
    organization_name VARCHAR(255) NOT NULL,
    contact_person VARCHAR(255) NULL,
    contact_phone VARCHAR(255) NULL,
    organization_address VARCHAR(255) NULL,
    description TEXT NULL,
    needs_list JSON NULL,
    document_url VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

#### Key Fields:
- **`user_id`**: One-to-one relationship with users table
- **`needs_list`**: JSON array of items the organization typically needs
- **`document_url`**: Legal documents for verification (scan of foundation certificate, etc.)

#### Relationship:
- **One-to-One** with `users` table
- If user is deleted → organization_details is deleted (CASCADE)

---

### 3. Donations Table (`donations`)

**Purpose**: Stores all donation items (both goods and money donations)

**Migration Files**: 
- `2025_06_05_180842_create_donations_table.php` (base table)
- `2025_06_13_090152_add_money_donation_fields_to_donations_table.php` (money donation fields)

#### Schema:
```sql
CREATE TABLE donations (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    category VARCHAR(255) NOT NULL,
    photos JSON NULL,
    status ENUM('pending', 'available', 'claimed', 'completed', 'cancelled') DEFAULT 'pending',
    donation_type ENUM('goods', 'money') DEFAULT 'goods',
    amount DECIMAL(12,2) NULL,
    payment_method ENUM('bank_transfer', 'e_wallet', 'cash') NULL,
    is_anonymous BOOLEAN DEFAULT FALSE,
    pickup_preference ENUM('self_deliver', 'needs_pickup') DEFAULT 'self_deliver',
    location VARCHAR(255) NULL,
    claimed_by_organization_id BIGINT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (claimed_by_organization_id) REFERENCES users(id) ON DELETE SET NULL
);
```

#### Key Fields:
- **`status`**: Donation lifecycle
  - `pending`: Awaiting admin verification
  - `available`: Approved by admin, ready for claiming
  - `claimed`: Claimed by an organization
  - `completed`: Successfully delivered and confirmed
  - `cancelled`: Donation was cancelled
- **`donation_type`**: Type of donation (goods or money)
- **`photos`**: JSON array of photo URLs for goods donations
- **`pickup_preference`**: How donatur wants to deliver the items

#### Relationships:
- **Many-to-One** with `users` (donatur who created the donation)
- **Many-to-One** with `users` (organization that claimed the donation)
- If donatur is deleted → donation is deleted (CASCADE)
- If organization is deleted → claimed_by_organization_id becomes NULL (SET NULL)

---

### 4. Donation Requests Table (`donation_requests`)

**Purpose**: Requests made by organizations for specific items they need

**Migration Files**:
- `2025_06_12_022923_create_donation_requests_table.php` (base table)
- `2025_06_12_023857_add_missing_columns_to_donation_requests_table.php` (additional fields)

#### Schema:
```sql
CREATE TABLE donation_requests (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    organization_id BIGINT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(255) NOT NULL,
    urgency_level ENUM('low', 'medium', 'high') DEFAULT 'medium',
    quantity_needed INT NULL,
    location VARCHAR(255) NULL,
    status ENUM('active', 'fulfilled', 'cancelled') DEFAULT 'active',
    needed_by DATE NULL,
    tags JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (organization_id) REFERENCES users(id) ON DELETE CASCADE
);
```

#### Key Fields:
- **`urgency_level`**: Priority level of the request
- **`status`**: Request status (active, fulfilled, cancelled)
- **`needed_by`**: Deadline when the items are needed
- **`tags`**: Additional keywords for better searchability

#### Relationships:
- **Many-to-One** with `users` (organization that created the request)
- If organization is deleted → request is deleted (CASCADE)

---

## 🔄 Table Relationships Diagram

```
┌─────────────────┐       ┌──────────────────────┐
│     USERS       │◄──────┤ ORGANIZATION_DETAILS │
│                 │  1:1  │                      │
│ • id            │       │ • user_id (FK)       │
│ • name          │       │ • organization_name  │
│ • email         │       │ • needs_list (JSON)  │
│ • role          │       └──────────────────────┘
│ • is_verified   │
└─────────────────┘
         │
         │ 1:M
         ▼
┌─────────────────┐       ┌──────────────────────┐
│    DONATIONS    │       │  DONATION_REQUESTS   │
│                 │       │                      │
│ • user_id (FK)  │       │ • organization_id(FK)│
│ • title         │◄──────┤ • title              │
│ • status        │  M:1  │ • urgency_level      │
│ • claimed_by... │       │ • status             │
│   (FK to users) │       └──────────────────────┘
└─────────────────┘
```

### Relationship Summary:

1. **Users ↔ Organization Details**: One-to-One (optional)
2. **Users → Donations**: One-to-Many (as donatur)
3. **Users → Donations**: One-to-Many (as claiming organization)
4. **Users → Donation Requests**: One-to-Many (as organization)

---

## 🌱 Database Seeders

### Seeder Execution Order

**File**: `database/seeders/DatabaseSeeder.php`

```php
public function run(): void
{
    $this->call([
        UserSeeder::class,
        AdminSeeder::class,
        DonaturSeeder::class,
        OrganizationSeeder::class,
        DonationSeeder::class,
    ]);
}
```

### 1. UserSeeder (`UserSeeder.php`)

**Purpose**: Creates basic test users for all roles

**Creates**:
- 1 Admin user (`admin@donasibarang.com`)
- 2 Donatur users (verified and unverified)
- 2 Organization users (verified and unverified)

**Default Password**: `password123` for all test users

### 2. AdminSeeder (`AdminSeeder.php`)

**Purpose**: Creates the main admin account for production

**Creates**:
- Main admin: `admin@berkahhbabe.com` with password `admin123`
- Uses `firstOrCreate()` to prevent duplicates

### 3. DonaturSeeder (`DonaturSeeder.php`)

**Purpose**: Creates additional donatur test accounts

### 4. OrganizationSeeder (`OrganizationSeeder.php`)

**Purpose**: Creates realistic organization accounts with complete profiles

**Creates 5 Organizations**:
1. **Panti Asuhan Harapan Bangsa** - Children's orphanage
2. **Yayasan Peduli Sesama** - Social foundation for underprivileged
3. **Panti Jompo Sejahtera** - Elderly care home
4. **Rumah Singgah Anak Jalanan** - Street children shelter
5. **Komunitas Berbagi Jakarta** - Community sharing organization

Each organization includes:
- Complete user account
- Organization details with realistic data
- Specific needs list (different categories for each)
- Contact information and addresses

### 5. DonationSeeder (`DonationSeeder.php`)

**Purpose**: Creates sample donations in various statuses

**Creates 6 Sample Donations**:
1. **Available** - Children's clothes
2. **Claimed** - Elementary school books
3. **Pending** - Used laptop
4. **Completed** - Educational toys
5. **Available** - School shoes
6. **Cancelled** - Kitchen equipment

Each donation has realistic:
- Titles and descriptions
- Different categories
- Various statuses to test workflow
- Pickup preferences

---

## 🚀 Running Migrations & Seeders

### Fresh Installation:
```bash
# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed
```

### Reset Database:
```bash
# Reset and reseed everything
php artisan migrate:fresh --seed
```

### Individual Seeders:
```bash
# Run specific seeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=OrganizationSeeder
```

---

## 🔍 Key Features of the Database Design

### 1. **Role-Based Access Control**
- Single `users` table with role differentiation
- Extended profiles only for organizations (optional)

### 2. **Flexible Donation System**
- Supports both goods and money donations
- Complete status tracking lifecycle
- Photo storage for goods donations

### 3. **Organization Management**
- Organizations can have detailed profiles
- Needs list helps match with donations
- Request system for specific needs

### 4. **Data Integrity**
- Proper foreign key constraints
- Cascade deletes where appropriate
- SET NULL for optional relationships

### 5. **Scalability**
- JSON fields for flexible data (photos, needs_list, tags)
- Indexed foreign keys for performance
- Timestamps for audit trails

---

## 📝 Notes for Developers

1. **Always run seeders after migrations** to have test data
2. **Use `migrate:fresh --seed`** during development to reset data
3. **Organization profiles are optional** - users can exist without organization_details
4. **Photos are stored as JSON arrays** - handle accordingly in frontend
5. **Status transitions** should be validated in application logic
6. **Money donations** use the same table as goods donations with additional fields

---

## 🛠️ Maintenance Commands

```bash
# Check migration status
php artisan migrate:status

# Rollback last migration
php artisan migrate:rollback

# Rollback specific number of migrations
php artisan migrate:rollback --step=3

# See raw SQL of migrations
php artisan migrate --pretend
```

This database structure provides a robust foundation for the donation platform while maintaining flexibility for future enhancements. 