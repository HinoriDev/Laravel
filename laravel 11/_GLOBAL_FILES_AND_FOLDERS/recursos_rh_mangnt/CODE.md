# Users

Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->bigInteger('department_id')->nullable();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->string('role', 50);
    $table->string('permissions', 1000);
    $table->timestamps();
    $table->softDeletes();
});

Schema::create('password_reset_tokens', function (Blueprint $table) {
    $table->string('email')->primary();
    $table->string('token');
    $table->timestamp('created_at')->nullable();
});

# User Details

Schema::create('user_details', function (Blueprint $table) {
    $table->id();
    $table->bigInteger('user_id');
    $table->string('address', 100);
    $table->string('zip_code', 10);
    $table->string('city', 50);
    $table->string('phone', 20);
    $table->decimal('salary', 10, 2);
    $table->date('admission_date');
    $table->timestamps();
});

# Departments

Schema::create('departments', function (Blueprint $table) {
    $table->id();
    $table->string('name', 50);
    $table->timestamps();
});

# ------------------------------------------
# Admin seed

// admin
DB::table('users')->insert([
    'department_id' => 1,   // Administração
    'name' => 'Administrador',
    'email' => 'admin@rhmangnt.com',
    'email_verified_at' => now(),
    'password' => bcrypt('Aa123456'),
    'role' => 'admin',
    'permissions' => '["admin"]',
    'created_at' => now(),
    'updated_at' => now(),
]);

// admin details
DB::table('user_details')->insert([
    'user_id' => 1,
    'address' => 'Rua do Administrador, 123',
    'zip_code' => '1234-123',
    'city' => 'Lisboa',
    'phone' => '900000001',
    'salary' => 8000.00,
    'admission_date' => '2020-01-01',
    'created_at' => now(),
    'updated_at' => now(),
]);

// admin department
DB::table('departments')->insert([
    'name' => 'Administração',
    'created_at' => now(),
    'updated_at' => now(),
]);

// regex
/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/