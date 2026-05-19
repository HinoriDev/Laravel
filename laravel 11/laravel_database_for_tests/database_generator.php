<?php

/* =======================================================================

Database Generator

1. Set configuration variables
2. Execute the script. It will generate SQL files for clients, phones, products, and orders
3. Import the SQL files into your database

======================================================================= */

// 50 random portuguese female first names
$first_names = [
    'Maria',
    'Ana',
    'Francisca',
    'Matilde',
    'Beatriz',
    'Mariana',
    'Leonor',
    'Carolina',
    'Ines',
    'Margarida',
    'Clara',
    'Diana',
    'Sofia',
    'Laura',
    'Rita',
    'Joana',
    'Catarina',
    'Lara',
    'Luana',
    'Alice',
    'Vitoria',
    'Eva',
    'Iris',
    'Marta',
    'Yara',
    'Lia',
    'Ariana',
    'Mafalda',
    'Isabel',
    'Barbara',
    'Luna',
    'Lucia',
    'Mia',
    'Liliana',
    'Daniela',
    'Monica',
    'Teresa',
    'Mara',
    'Melany',
    'Micaela',
    'Mirela',
    'Morgana',
    'Nara',
    'Natalina',
    'Nayara',
    'Nuria',
    'Olivia',
    'Palmira',
    'Pandora',
    'Susana'
];

// 50 random portuguese last names
$last_names = [
    'Silva',
    'Santos',
    'Ferreira',
    'Pereira',
    'Oliveira',
    'Costa',
    'Rodrigues',
    'Martins',
    'Jesus',
    'Sousa',
    'Fernandes',
    'Goncalves',
    'Lopes',
    'Gomes',
    'Marques',
    'Almeida',
    'Alves',
    'Ribeiro',
    'Carvalho',
    'Teixeira',
    'Moreira',
    'Correia',
    'Mendes',
    'Nunes',
    'Vieira',
    'Monteiro',
    'Cardoso',
    'Rocha',
    'Coelho',
    'Pinto',
    'Cruz',
    'Araujo',
    'Machado',
    'Neves',
    'Leal',
    'Dias',
    'Reis',
    'Cunha',
    'Barbosa',
    'Saraiva',
    'Borges',
    'Freitas',
    'Vaz',
    'Figueiredo',
    'Magalhaes',
    'Henriques',
    'Pinheiro',
    'Pacheco',
    'Peixoto',
    'Costa'
];

// list of 10 email domains
$email_domains = [
    'gmail.com',
    'yahoo.com',
    'hotmail.com',
    'aol.com',
    'outlook.com',
    'icloud.com',
    'protonmail.com',
    'zoho.com',
    'yandex.com',
    'mail.com'
];

// list of 30 product names
$product_names = [
    'Maca',
    'Banana',
    'Laranja',
    'Uvas',
    'Morango',
    'Mirtilo',
    'Framboesa',
    'Amora',
    'Abacaxi',
    'Melancia',
    'Melao',
    'Kiwi',
    'Manga',
    'Pessego',
    'Ameixa',
    'Pera',
    'Cereja',
    'Limao',
    'Coco',
    'Roma',
    'Abacate',
    'Tomate',
    'Pepino',
    'Cenoura',
    'Aipo',
    'Alface',
    'Couve-flor',
    'Repolho',
    'Batata',
    'Pera',
];

// ---------------------------------------------------
// CONFIGURATION VARIABLES
$total_clients = 500;
$percentage_of_inactive_clients = 10; // %
$percentage_of_soft_deleted_clients = 5; // %
$max_phone_numbers_per_client = 3;
$total_orders = 10000;
$max_products_per_order = 6;
$max_quantity_per_product = 15;

// ---------------------------------------------------
// generate clients
$start_date = new DateTime();
$start_date->setDate(rand(2030, 2040), rand(1,12), rand(1,25))->setTime(rand(9,20), rand(0,59), rand(0,59));

$clients = [];
for($i = 0; $i < $total_clients; $i++) {

    $client_name = generate_client_name();

    $client = [
        'id' => $i + 1,
        'client_name' => $client_name,
        'email' => generate_email(explode(' ', $client_name)[0], explode(' ', $client_name)[count(explode(' ', $client_name)) - 1]),
        'active' => rand(1, 100) > $percentage_of_inactive_clients ? true : false,
        'created_at' => $start_date->format('Y-m-d H:i:s'),
        'updated_at' => $start_date->format('Y-m-d H:i:s'),
        'deleted_at' => rand(1, 100) > $percentage_of_soft_deleted_clients ? null : $start_date->format('Y-m-d H:i:s'),
    ];
    $clients[] = $client;

    $start_date->add(new DateInterval('PT' . rand(1, 86400) . 'S'));
}

// ---------------------------------------------------
// generate phones
$phones = [];
$index = 1;
foreach($clients as $client) {
    $total_phones = rand(1, $max_phone_numbers_per_client);

    for($i = 0; $i < $total_phones; $i++) {
        $phones[] = [
            'id' => $index++,
            'client_id' => $client['id'],
            'phone_number' => generate_phone_number(),
            'created_at' => $start_date->format('Y-m-d H:i:s'),
            'updated_at' => $start_date->format('Y-m-d H:i:s'),
            'deleted_at' => null,
        ];
    }

    $start_date->add(new DateInterval('PT' . rand(1, 1000) . 'S'));
}

// ---------------------------------------------------
// products
$products = [];
$start_date->add(new DateInterval('P10D'));
for($i = 0; $i < count($product_names); $i++) {
    $products[] = [
        'id' => $i + 1,
        'product_name' => $product_names[$i],
        // random price between 10.00 and 100.00
        'price' => number_format(rand(1000, 10000) / 100, 2),
        'created_at' => $start_date->format('Y-m-d H:i:s'),
        'updated_at' => $start_date->format('Y-m-d H:i:s'),
        'deleted_at' => null,
    ];
}

// ---------------------------------------------------
// generate orders
$orders = [];
$index = 1;
$order_number = 1;
while(count($orders) < $total_orders) {

    $client = $clients[array_rand($clients)];

    if(!$client['active'] || $client['deleted_at'] != null) {
        continue;
    }

    $total_products = rand(1, $max_products_per_order);

    $start_date->add(new DateInterval('PT' . rand(86400, 86400 * 3) . 'S'));

    for($i = 0; $i < $total_products; $i++) {
        $product = $products[array_rand($products)];
        $quantity = rand(1, $max_quantity_per_product);

        $orders[] = [
            'id' => $index++,
            'order_number' => $order_number,
            'client_id' => $client['id'],
            'product_id' => $product['id'],
            'quantity' => $quantity,
            'created_at' => $start_date->format('Y-m-d H:i:s'),
            'updated_at' => $start_date->format('Y-m-d H:i:s'),
            'deleted_at' => null,
        ];
    }

    $order_number++;
}

// ---------------------------------------------------
// export data to sql files

// create sql_files directory if it doesn't exist
if(!file_exists(__DIR__ . '/sql_files')) {
    mkdir(__DIR__ . '/sql_files');
}

// clients
$clients_sql = 'INSERT INTO clients (id, client_name, email, active, created_at, updated_at, deleted_at) VALUES' . PHP_EOL;
foreach($clients as $client) {
    $endchar = $client['id'] == count($clients) ? ';' : ',';
    $clients_sql .= '(' . $client['id'] . ', "' . $client['client_name'] . '", "' . $client['email'] . '", ' . ($client['active'] ? '1' : '0') . ', "' . $client['created_at'] . '", "' . $client['updated_at'] . '", ' . ($client['deleted_at'] == null ? 'NULL' : '"' . $client['deleted_at'] . '"') . ')' . $endchar . PHP_EOL;
}
file_put_contents(__DIR__ . '/sql_files/clients.sql', $clients_sql);

// phones
$phones_sql = 'INSERT INTO phones (id, client_id, phone_number, created_at, updated_at, deleted_at) VALUES' . PHP_EOL;
foreach($phones as $phone) {
    $endchar = $phone['id'] == count($phones) ? ';' : ',';
    $phones_sql .= '(' . $phone['id'] . ', ' . $phone['client_id'] . ', ' . $phone['phone_number'] . ', "' . $phone['created_at'] . '", "' . $phone['updated_at'] . '", ' . ($phone['deleted_at'] == null ? 'NULL' : '"' . $phone['deleted_at'] . '"') . ')' . $endchar . PHP_EOL;
}
file_put_contents(__DIR__ . '/sql_files/phones.sql', $phones_sql);

// products
$products_sql = 'INSERT INTO products (id, product_name, price, created_at, updated_at, deleted_at) VALUES' . PHP_EOL;
foreach($products as $product) {
    $endchar = $product['id'] == count($products) ? ';' : ',';
    $products_sql .= '(' . $product['id'] . ', "' . $product['product_name'] . '", ' . $product['price'] . ', "' . $product['created_at'] . '", "' . $product['updated_at'] . '", ' . ($product['deleted_at'] == null ? 'NULL' : '"' . $product['deleted_at'] . '"') . ')' . $endchar . PHP_EOL;
}
file_put_contents(__DIR__ . '/sql_files/products.sql', $products_sql);

// orders
$orders_sql = 'INSERT INTO orders (id, order_number, client_id, product_id, quantity, created_at, updated_at, deleted_at) VALUES' . PHP_EOL;
foreach($orders as $order) {
    $endchar = $order['id'] == count($orders) ? ';' : ',';
    $orders_sql .= '(' . $order['id'] . ', ' . $order['order_number'] . ', ' . $order['client_id'] . ', ' . $order['product_id'] . ', ' . $order['quantity'] . ', "' . $order['created_at'] . '", "' . $order['updated_at'] . '", ' . ($order['deleted_at'] == null ? 'NULL' : '"' . $order['deleted_at'] . '"') . ')' . $endchar . PHP_EOL;
}
file_put_contents(__DIR__ . '/sql_files/orders.sql', $orders_sql);

// ---------------------------------------------------
// display data
echo 'Total Clients: ' . count($clients) . PHP_EOL;
echo 'Total Phones: ' . count($phones) . PHP_EOL;
echo 'Total Products: ' . count($products) . PHP_EOL;
echo 'Total Orders: ' . count($orders) . PHP_EOL;

// ---------------------------------------------------
function generate_client_name() {
    global $first_names, $last_names;

    $name1 = '';
    $name2 = '';
    $last_name1 = '';
    $last_name2 = '';

    $name1 = $first_names[array_rand($first_names)];
    do {
        $name2 = $first_names[array_rand($first_names)];
    } while($name1 == $name2);

    $last_name1 = $last_names[array_rand($last_names)];
    do {
        $last_name2 = $last_names[array_rand($last_names)];
    } while($last_name1 == $last_name2);

    if(rand(1, 100) > 50) {
        return "$name1 $name2 $last_name1";
    } else {
        return "$name1 $name2 $last_name1 $last_name2";
    }
}

function generate_email($first_name, $last_name) {
    global $email_domains;
    $domain = $email_domains[array_rand($email_domains)];
    $email = strtolower($first_name) . '.' . rand(1000,9999) . '.' . strtolower($last_name) . '@' . $domain;
    return $email;
}

function generate_phone_number() {
    return rand(100000000, 999999999);
}