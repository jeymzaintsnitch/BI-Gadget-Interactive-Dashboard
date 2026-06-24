<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Roles ────────────────────────────────────────────────────
        DB::table('roles')->updateOrInsert(['name' => 'Admin'], [
            'description' => 'Full system access', 'created_at' => now(), 'updated_at' => now()
        ]);
        DB::table('roles')->updateOrInsert(['name' => 'Staff'], [
            'description' => 'Standard staff access', 'created_at' => now(), 'updated_at' => now()
        ]);

        $adminRoleId = DB::table('roles')->where('name', 'Admin')->value('id');
        $staffRoleId = DB::table('roles')->where('name', 'Staff')->value('id');

        // ── Admin User ───────────────────────────────────────────────
        DB::table('users')->updateOrInsert(['email' => 'admin@gadgetstore.com'], [
            'name' => 'Admin', 'password' => Hash::make('password'), 'role_id' => $adminRoleId,
            'created_at' => now(), 'updated_at' => now()
        ]);

        // ── Staff User ───────────────────────────────────────────────
        DB::table('users')->updateOrInsert(['email' => 'staff@gadgetstore.com'], [
            'name' => 'Staff User', 'password' => Hash::make('password'), 'role_id' => $staffRoleId,
            'created_at' => now(), 'updated_at' => now()
        ]);

        // ── Offices ──────────────────────────────────────────────────
        DB::table('offices')->insert([
            ['officeCode' => '1', 'city' => 'Manila',      'phone' => '+63 2 8888 1234', 'addressLine1' => '100 Makati Ave',        'country' => 'Philippines', 'postalCode' => '1226', 'territory' => 'APAC'],
            ['officeCode' => '2', 'city' => 'Singapore',   'phone' => '+65 6220 0000',   'addressLine1' => '8 Raffles Place',       'country' => 'Singapore',   'postalCode' => '048624','territory' => 'APAC'],
            ['officeCode' => '3', 'city' => 'New York',    'phone' => '+1 212 555 0100', 'addressLine1' => '350 Fifth Avenue',      'country' => 'USA',         'postalCode' => '10118', 'territory' => 'NA'],
            ['officeCode' => '4', 'city' => 'London',      'phone' => '+44 20 7946 0958','addressLine1' => '10 Downing Street',     'country' => 'UK',          'postalCode' => 'SW1A 2AA','territory' => 'EMEA'],
            ['officeCode' => '5', 'city' => 'Tokyo',       'phone' => '+81 3 1234 5678', 'addressLine1' => '1-1 Shinjuku',          'country' => 'Japan',       'postalCode' => '163-8001','territory' => 'Japan'],
            ['officeCode' => '6', 'city' => 'Sydney',      'phone' => '+61 2 9000 1234', 'addressLine1' => '1 Macquarie Place',     'country' => 'Australia',   'postalCode' => '2000',  'territory' => 'APAC'],
            ['officeCode' => '7', 'city' => 'Paris',       'phone' => '+33 1 4200 0000', 'addressLine1' => '1 Rue de la Paix',      'country' => 'France',      'postalCode' => '75001', 'territory' => 'EMEA'],
        ]);

        // ── Employees ────────────────────────────────────────────────
        DB::table('employees')->insert([
            ['employeeNumber' => 1001, 'lastName' => 'Garcia',   'firstName' => 'Maria',   'extension' => 'x5800', 'email' => 'mgarcia@gadgetstore.com',   'officeCode' => '1', 'reportsTo' => null, 'jobTitle' => 'President'],
            ['employeeNumber' => 1002, 'lastName' => 'Reyes',    'firstName' => 'Juan',    'extension' => 'x5801', 'email' => 'jreyes@gadgetstore.com',     'officeCode' => '1', 'reportsTo' => 1001, 'jobTitle' => 'VP Sales'],
            ['employeeNumber' => 1003, 'lastName' => 'Santos',   'firstName' => 'Ana',     'extension' => 'x5802', 'email' => 'asantos@gadgetstore.com',    'officeCode' => '1', 'reportsTo' => 1002, 'jobTitle' => 'Sales Rep'],
            ['employeeNumber' => 1004, 'lastName' => 'Cruz',     'firstName' => 'Pedro',   'extension' => 'x5803', 'email' => 'pcruz@gadgetstore.com',      'officeCode' => '1', 'reportsTo' => 1002, 'jobTitle' => 'Sales Rep'],
            ['employeeNumber' => 1005, 'lastName' => 'Lim',      'firstName' => 'James',   'extension' => 'x5804', 'email' => 'jlim@gadgetstore.com',       'officeCode' => '2', 'reportsTo' => 1002, 'jobTitle' => 'Sales Rep'],
            ['employeeNumber' => 1006, 'lastName' => 'Tan',      'firstName' => 'Sarah',   'extension' => 'x5805', 'email' => 'stan@gadgetstore.com',       'officeCode' => '2', 'reportsTo' => 1002, 'jobTitle' => 'Sales Rep'],
            ['employeeNumber' => 1007, 'lastName' => 'Smith',    'firstName' => 'John',    'extension' => 'x5806', 'email' => 'jsmith@gadgetstore.com',     'officeCode' => '3', 'reportsTo' => 1002, 'jobTitle' => 'Sales Rep'],
            ['employeeNumber' => 1008, 'lastName' => 'Johnson',  'firstName' => 'Emily',   'extension' => 'x5807', 'email' => 'ejohnson@gadgetstore.com',   'officeCode' => '3', 'reportsTo' => 1002, 'jobTitle' => 'Sales Rep'],
            ['employeeNumber' => 1009, 'lastName' => 'Brown',    'firstName' => 'Michael', 'extension' => 'x5808', 'email' => 'mbrown@gadgetstore.com',     'officeCode' => '4', 'reportsTo' => 1002, 'jobTitle' => 'Sales Rep'],
            ['employeeNumber' => 1010, 'lastName' => 'Nakamura', 'firstName' => 'Yuki',    'extension' => 'x5809', 'email' => 'ynakamura@gadgetstore.com',  'officeCode' => '5', 'reportsTo' => 1002, 'jobTitle' => 'Sales Rep'],
            ['employeeNumber' => 1011, 'lastName' => 'Wilson',   'firstName' => 'Claire',  'extension' => 'x5810', 'email' => 'cwilson@gadgetstore.com',    'officeCode' => '6', 'reportsTo' => 1002, 'jobTitle' => 'Sales Rep'],
            ['employeeNumber' => 1012, 'lastName' => 'Dupont',   'firstName' => 'Luc',     'extension' => 'x5811', 'email' => 'ldupont@gadgetstore.com',    'officeCode' => '7', 'reportsTo' => 1002, 'jobTitle' => 'Sales Rep'],
        ]);

        // ── Product Lines ────────────────────────────────────────────
        DB::table('productlines')->insert([
            ['productLine' => 'Smartphones',    'textDescription' => 'Latest flagship and mid-range smartphones from top brands.'],
            ['productLine' => 'Laptops',        'textDescription' => 'High-performance laptops for work, gaming, and creativity.'],
            ['productLine' => 'Audio',          'textDescription' => 'Premium headphones, earbuds, and speakers.'],
            ['productLine' => 'Wearables',      'textDescription' => 'Smartwatches and fitness trackers.'],
            ['productLine' => 'Cameras',        'textDescription' => 'DSLRs, mirrorless cameras, and accessories.'],
            ['productLine' => 'Gaming',         'textDescription' => 'Consoles, controllers, and gaming peripherals.'],
            ['productLine' => 'Accessories',    'textDescription' => 'Cables, cases, chargers, and more.'],
        ]);

        // ── Products ─────────────────────────────────────────────────
        DB::table('products')->insert([
            ['productCode' => 'S10_1', 'productName' => 'iPhone 15 Pro',           'productLine' => 'Smartphones', 'productScale' => '1:1', 'productVendor' => 'Apple',    'productDescription' => 'Apple flagship smartphone with A17 Pro chip.', 'quantityInStock' => 250,  'buyPrice' => 799.00,  'MSRP' => 999.00],
            ['productCode' => 'S10_2', 'productName' => 'Samsung Galaxy S24',      'productLine' => 'Smartphones', 'productScale' => '1:1', 'productVendor' => 'Samsung',  'productDescription' => 'Android flagship with AI features.',            'quantityInStock' => 300,  'buyPrice' => 699.00,  'MSRP' => 849.00],
            ['productCode' => 'S10_3', 'productName' => 'Google Pixel 8',          'productLine' => 'Smartphones', 'productScale' => '1:1', 'productVendor' => 'Google',   'productDescription' => 'Pure Android experience with great camera.',   'quantityInStock' => 150,  'buyPrice' => 499.00,  'MSRP' => 699.00],
            ['productCode' => 'S10_4', 'productName' => 'OnePlus 12',              'productLine' => 'Smartphones', 'productScale' => '1:1', 'productVendor' => 'OnePlus',  'productDescription' => 'Fast and smooth flagship killer.',              'quantityInStock' => 120,  'buyPrice' => 449.00,  'MSRP' => 649.00],
            ['productCode' => 'L10_1', 'productName' => 'MacBook Pro 14"',         'productLine' => 'Laptops',     'productScale' => '1:1', 'productVendor' => 'Apple',    'productDescription' => 'M3 Pro chip, perfect for professionals.',       'quantityInStock' => 100,  'buyPrice' => 1399.00, 'MSRP' => 1999.00],
            ['productCode' => 'L10_2', 'productName' => 'Dell XPS 15',             'productLine' => 'Laptops',     'productScale' => '1:1', 'productVendor' => 'Dell',     'productDescription' => 'Premium Windows laptop with OLED display.',    'quantityInStock' => 80,   'buyPrice' => 1199.00, 'MSRP' => 1799.00],
            ['productCode' => 'L10_3', 'productName' => 'Lenovo ThinkPad X1',      'productLine' => 'Laptops',     'productScale' => '1:1', 'productVendor' => 'Lenovo',   'productDescription' => 'Business ultrabook with great keyboard.',       'quantityInStock' => 90,   'buyPrice' => 999.00,  'MSRP' => 1499.00],
            ['productCode' => 'L10_4', 'productName' => 'ASUS ROG Zephyrus',       'productLine' => 'Laptops',     'productScale' => '1:1', 'productVendor' => 'ASUS',     'productDescription' => 'Gaming laptop with RTX 4070.',                 'quantityInStock' => 60,   'buyPrice' => 1299.00, 'MSRP' => 1799.00],
            ['productCode' => 'A10_1', 'productName' => 'Sony WH-1000XM5',         'productLine' => 'Audio',       'productScale' => '1:1', 'productVendor' => 'Sony',     'productDescription' => 'Best-in-class noise cancelling headphones.',    'quantityInStock' => 200,  'buyPrice' => 199.00,  'MSRP' => 349.00],
            ['productCode' => 'A10_2', 'productName' => 'Apple AirPods Pro 2',     'productLine' => 'Audio',       'productScale' => '1:1', 'productVendor' => 'Apple',    'productDescription' => 'Active noise cancellation earbuds.',            'quantityInStock' => 350,  'buyPrice' => 149.00,  'MSRP' => 249.00],
            ['productCode' => 'A10_3', 'productName' => 'Bose SoundLink Max',      'productLine' => 'Audio',       'productScale' => '1:1', 'productVendor' => 'Bose',     'productDescription' => 'Portable Bluetooth speaker.',                  'quantityInStock' => 180,  'buyPrice' => 229.00,  'MSRP' => 329.00],
            ['productCode' => 'W10_1', 'productName' => 'Apple Watch Series 9',    'productLine' => 'Wearables',   'productScale' => '1:1', 'productVendor' => 'Apple',    'productDescription' => 'Advanced health tracking smartwatch.',          'quantityInStock' => 220,  'buyPrice' => 279.00,  'MSRP' => 399.00],
            ['productCode' => 'W10_2', 'productName' => 'Samsung Galaxy Watch 6',  'productLine' => 'Wearables',   'productScale' => '1:1', 'productVendor' => 'Samsung',  'productDescription' => 'Android smartwatch with health sensors.',       'quantityInStock' => 190,  'buyPrice' => 179.00,  'MSRP' => 299.00],
            ['productCode' => 'W10_3', 'productName' => 'Garmin Fenix 7',          'productLine' => 'Wearables',   'productScale' => '1:1', 'productVendor' => 'Garmin',   'productDescription' => 'Rugged GPS sports watch.',                     'quantityInStock' => 100,  'buyPrice' => 399.00,  'MSRP' => 599.00],
            ['productCode' => 'C10_1', 'productName' => 'Sony A7 IV',              'productLine' => 'Cameras',     'productScale' => '1:1', 'productVendor' => 'Sony',     'productDescription' => 'Full-frame mirrorless camera.',                'quantityInStock' => 50,   'buyPrice' => 1899.00, 'MSRP' => 2499.00],
            ['productCode' => 'C10_2', 'productName' => 'Canon EOS R6 Mark II',    'productLine' => 'Cameras',     'productScale' => '1:1', 'productVendor' => 'Canon',    'productDescription' => 'Professional mirrorless camera.',              'quantityInStock' => 45,   'buyPrice' => 1699.00, 'MSRP' => 2299.00],
            ['productCode' => 'G10_1', 'productName' => 'PlayStation 5',           'productLine' => 'Gaming',      'productScale' => '1:1', 'productVendor' => 'Sony',     'productDescription' => 'Next-gen gaming console.',                     'quantityInStock' => 80,   'buyPrice' => 349.00,  'MSRP' => 499.00],
            ['productCode' => 'G10_2', 'productName' => 'Xbox Series X',           'productLine' => 'Gaming',      'productScale' => '1:1', 'productVendor' => 'Microsoft','productDescription' => 'Most powerful Xbox ever.',                     'quantityInStock' => 70,   'buyPrice' => 349.00,  'MSRP' => 499.00],
            ['productCode' => 'G10_3', 'productName' => 'Nintendo Switch OLED',    'productLine' => 'Gaming',      'productScale' => '1:1', 'productVendor' => 'Nintendo', 'productDescription' => 'Hybrid gaming console with OLED screen.',       'quantityInStock' => 150,  'buyPrice' => 249.00,  'MSRP' => 349.00],
            ['productCode' => 'AC1_1', 'productName' => 'Anker USB-C Hub 7-in-1',  'productLine' => 'Accessories', 'productScale' => '1:1', 'productVendor' => 'Anker',    'productDescription' => 'Multi-port hub for laptops.',                  'quantityInStock' => 500,  'buyPrice' => 25.00,   'MSRP' => 49.00],
            ['productCode' => 'AC1_2', 'productName' => 'MagSafe Charger 15W',     'productLine' => 'Accessories', 'productScale' => '1:1', 'productVendor' => 'Apple',    'productDescription' => 'Wireless fast charger for iPhone.',             'quantityInStock' => 400,  'buyPrice' => 24.00,   'MSRP' => 39.00],
            ['productCode' => 'AC1_3', 'productName' => 'Samsung 65W Charger',     'productLine' => 'Accessories', 'productScale' => '1:1', 'productVendor' => 'Samsung',  'productDescription' => 'Super-fast USB-C charger.',                    'quantityInStock' => 350,  'buyPrice' => 19.00,   'MSRP' => 35.00],
        ]);

        // ── Customers ────────────────────────────────────────────────
        $customers = [
            [101,'TechZone Manila',   'Dela Cruz','Marissa','+63 2 123 4567','123 EDSA',  null,'Manila',   'Metro Manila','1000','Philippines',1003,50000.00],
            [102,'Gadget Hub SG',     'Ong',      'Kevin',  '+65 6111 2222','10 Orchard Rd',null,'Singapore', null,'238888','Singapore',  1005,80000.00],
            [103,'NYC Electronics',   'Cohen',    'David',  '+1 212 111 2222','500 5th Ave', null,'New York', 'NY','10110','USA',         1007,100000.00],
            [104,'London Gadgets',    'Williams', 'Sophie', '+44 20 1234 5678','20 Oxford St',null,'London',   null,'W1A 1AB','UK',        1009,75000.00],
            [105,'Tokyo Tech',        'Suzuki',   'Hiroshi','+81 3 9876 5432','2-2 Akihabara',null,'Tokyo',   null,'101-0021','Japan',    1010,90000.00],
            [106,'Sydney Devices',    'Murphy',   'Liam',   '+61 2 8888 9999','5 George St', null,'Sydney',  'NSW','2000','Australia',   1011,60000.00],
            [107,'Paris Electro',     'Martin',   'Claire', '+33 1 5555 6666','15 Rue Rivoli',null,'Paris',   null,'75001','France',      1012,70000.00],
            [108,'Digital World MNL', 'Aquino',   'Jose',   '+63 32 222 3333','88 Colon St', null,'Cebu',    null,'6000','Philippines',  1004,45000.00],
            [109,'Smart Gear KL',     'Rahman',   'Amir',   '+60 3 1234 5678','88 Jalan Ampang',null,'Kuala Lumpur',null,'50450','Malaysia',1006,55000.00],
            [110,'Seoul Electronics', 'Kim',      'Hyun',   '+82 2 1234 5678','100 Gangnam-daero',null,'Seoul',null,'06234','South Korea',1005,65000.00],
            [111,'BerlinTech',        'Muller',   'Hans',   '+49 30 1234 5678','Unter den Linden 1',null,'Berlin',null,'10117','Germany', 1009,72000.00],
            [112,'CanadaTech Store',  'Tremblay', 'Marie',  '+1 416 555 0199','100 King St W',null,'Toronto', 'ON','M5X 1A9','Canada',   1007,58000.00],
        ];
        foreach ($customers as $c) {
            DB::table('customers')->insert([
                'customerNumber' => $c[0], 'customerName' => $c[1],
                'contactLastName' => $c[2], 'contactFirstName' => $c[3],
                'phone' => $c[4], 'addressLine1' => $c[5], 'addressLine2' => $c[6],
                'city' => $c[7], 'state' => $c[8], 'postalCode' => $c[9],
                'country' => $c[10], 'salesRepEmployeeNumber' => $c[11], 'creditLimit' => $c[12],
            ]);
        }

        // ── Orders & Order Details ───────────────────────────────────
        $orderData = [
            // [orderNumber, orderDate, requiredDate, shippedDate, status, customerNumber, [[productCode, qty, price]...]]
            [1001,'2023-01-05','2023-01-15','2023-01-10','Shipped',   101,[['S10_1',2,999.00],['A10_2',3,249.00],['AC1_2',5,39.00]]],
            [1002,'2023-01-12','2023-01-22','2023-01-18','Shipped',   102,[['L10_1',1,1999.00],['A10_1',2,349.00]]],
            [1003,'2023-02-03','2023-02-13','2023-02-08','Shipped',   103,[['G10_1',2,499.00],['G10_3',1,349.00],['AC1_1',4,49.00]]],
            [1004,'2023-02-14','2023-02-24','2023-02-20','Shipped',   104,[['S10_2',3,849.00],['W10_1',2,399.00]]],
            [1005,'2023-03-01','2023-03-11','2023-03-07','Shipped',   105,[['C10_1',1,2499.00],['A10_3',2,329.00]]],
            [1006,'2023-03-15','2023-03-25',null,        'Cancelled', 106,[['L10_2',1,1799.00]]],
            [1007,'2023-04-02','2023-04-12','2023-04-09','Shipped',   107,[['S10_3',2,699.00],['W10_2',1,299.00],['AC1_3',3,35.00]]],
            [1008,'2023-04-18','2023-04-28','2023-04-26','Shipped',   108,[['G10_2',1,499.00],['AC1_1',2,49.00]]],
            [1009,'2023-05-05','2023-05-15','2023-05-20','Shipped',   109,[['L10_3',2,1499.00],['A10_1',1,349.00]]],
            [1010,'2023-05-20','2023-05-30','2023-05-28','Shipped',   110,[['S10_1',1,999.00],['W10_3',1,599.00]]],
            [1011,'2023-06-01','2023-06-11','2023-06-08','Shipped',   111,[['L10_4',1,1799.00],['G10_3',2,349.00]]],
            [1012,'2023-06-15','2023-06-25','2023-06-22','Shipped',   112,[['S10_4',2,649.00],['A10_2',3,249.00]]],
            [1013,'2023-07-03','2023-07-13','2023-07-15','Shipped',   101,[['C10_2',1,2299.00],['A10_3',1,329.00]]],
            [1014,'2023-07-20','2023-07-30','2023-07-27','Shipped',   102,[['S10_2',2,849.00],['AC1_1',5,49.00]]],
            [1015,'2023-08-05','2023-08-15','2023-08-12','Shipped',   103,[['L10_1',2,1999.00],['W10_1',2,399.00]]],
            [1016,'2023-08-22','2023-09-01','2023-09-05','Shipped',   104,[['G10_1',1,499.00],['G10_2',1,499.00]]],
            [1017,'2023-09-10','2023-09-20','2023-09-17','Shipped',   105,[['S10_3',3,699.00],['A10_1',2,349.00]]],
            [1018,'2023-09-25','2023-10-05','2023-10-02','Shipped',   106,[['L10_2',1,1799.00],['AC1_2',4,39.00]]],
            [1019,'2023-10-08','2023-10-18','2023-10-14','Shipped',   107,[['W10_3',2,599.00],['S10_4',1,649.00]]],
            [1020,'2023-10-25','2023-11-04','2023-11-03','Shipped',   108,[['C10_1',1,2499.00],['A10_2',2,249.00]]],
            [1021,'2023-11-05','2023-11-15','2023-11-11','Shipped',   109,[['S10_1',2,999.00],['L10_3',1,1499.00]]],
            [1022,'2023-11-20','2023-11-30','2023-11-28','Shipped',   110,[['G10_3',3,349.00],['AC1_1',3,49.00]]],
            [1023,'2023-12-01','2023-12-11','2023-12-08','Shipped',   111,[['S10_2',4,849.00],['A10_3',2,329.00]]],
            [1024,'2023-12-15','2023-12-25','2023-12-22','Shipped',   112,[['L10_4',1,1799.00],['W10_2',2,299.00]]],
            [1025,'2024-01-08','2024-01-18','2024-01-15','Shipped',   101,[['S10_1',3,999.00],['AC1_2',6,39.00],['A10_1',1,349.00]]],
            [1026,'2024-01-22','2024-02-01','2024-01-29','Shipped',   102,[['C10_2',1,2299.00],['G10_1',2,499.00]]],
            [1027,'2024-02-10','2024-02-20','2024-02-16','Shipped',   103,[['L10_1',1,1999.00],['S10_3',2,699.00]]],
            [1028,'2024-02-25','2024-03-07','2024-03-04','Shipped',   104,[['W10_1',3,399.00],['AC1_3',5,35.00]]],
            [1029,'2024-03-05','2024-03-15',null,        'Processing',105,[['G10_2',2,499.00],['A10_2',4,249.00]]],
            [1030,'2024-03-20','2024-03-30','2024-03-27','Shipped',   106,[['S10_2',2,849.00],['L10_2',1,1799.00]]],
        ];

        foreach ($orderData as $o) {
            DB::table('orders')->insert([
                'orderNumber'   => $o[0],
                'orderDate'     => $o[1],
                'requiredDate'  => $o[2],
                'shippedDate'   => $o[3],
                'status'        => $o[4],
                'customerNumber'=> $o[5],
            ]);
            $lineNum = 1;
            foreach ($o[6] as $item) {
                DB::table('orderdetails')->insert([
                    'orderNumber'     => $o[0],
                    'productCode'     => $item[0],
                    'quantityOrdered' => $item[1],
                    'priceEach'       => $item[2],
                    'orderLineNumber' => $lineNum++,
                ]);
            }
        }

        // ── Payments ─────────────────────────────────────────────────
        DB::table('payments')->insert([
            ['customerNumber' => 101, 'checkNumber' => 'CHK001', 'paymentDate' => '2023-01-20', 'amount' => 2690.00],
            ['customerNumber' => 102, 'checkNumber' => 'CHK002', 'paymentDate' => '2023-01-28', 'amount' => 2697.00],
            ['customerNumber' => 103, 'checkNumber' => 'CHK003', 'paymentDate' => '2023-02-15', 'amount' => 1543.00],
            ['customerNumber' => 104, 'checkNumber' => 'CHK004', 'paymentDate' => '2023-02-28', 'amount' => 3345.00],
            ['customerNumber' => 105, 'checkNumber' => 'CHK005', 'paymentDate' => '2023-03-15', 'amount' => 3157.00],
            ['customerNumber' => 106, 'checkNumber' => 'CHK006', 'paymentDate' => '2023-04-05', 'amount' => 3628.00],
            ['customerNumber' => 107, 'checkNumber' => 'CHK007', 'paymentDate' => '2023-04-20', 'amount' => 1548.00],
            ['customerNumber' => 108, 'checkNumber' => 'CHK008', 'paymentDate' => '2023-05-10', 'amount' => 597.00],
            ['customerNumber' => 109, 'checkNumber' => 'CHK009', 'paymentDate' => '2023-05-28', 'amount' => 3347.00],
            ['customerNumber' => 110, 'checkNumber' => 'CHK010', 'paymentDate' => '2023-06-10', 'amount' => 1598.00],
        ]);
    }
}
