<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->string('officeCode', 10)->primary();
            $table->string('city', 50);
            $table->string('phone', 50);
            $table->string('addressLine1', 50);
            $table->string('addressLine2', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('country', 50);
            $table->string('postalCode', 15);
            $table->string('territory', 10);
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->integer('employeeNumber')->primary();
            $table->string('lastName', 50);
            $table->string('firstName', 50);
            $table->string('extension', 10);
            $table->string('email', 100);
            $table->string('officeCode', 10);
            $table->integer('reportsTo')->nullable();
            $table->string('jobTitle', 50);
            $table->foreign('officeCode')->references('officeCode')->on('offices');
        });

        Schema::create('productlines', function (Blueprint $table) {
            $table->string('productLine', 50)->primary();
            $table->string('textDescription', 4000)->nullable();
            $table->text('htmlDescription')->nullable();
            $table->binary('image')->nullable();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->string('productCode', 15)->primary();
            $table->string('productName', 70);
            $table->string('productLine', 50);
            $table->string('productScale', 10);
            $table->string('productVendor', 50);
            $table->text('productDescription');
            $table->smallInteger('quantityInStock');
            $table->decimal('buyPrice', 10, 2);
            $table->decimal('MSRP', 10, 2);
            $table->foreign('productLine')->references('productLine')->on('productlines');
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->integer('customerNumber')->primary();
            $table->string('customerName', 50);
            $table->string('contactLastName', 50);
            $table->string('contactFirstName', 50);
            $table->string('phone', 50);
            $table->string('addressLine1', 50);
            $table->string('addressLine2', 50)->nullable();
            $table->string('city', 50);
            $table->string('state', 50)->nullable();
            $table->string('postalCode', 15)->nullable();
            $table->string('country', 50);
            $table->integer('salesRepEmployeeNumber')->nullable();
            $table->decimal('creditLimit', 10, 2)->nullable();
            $table->foreign('salesRepEmployeeNumber')->references('employeeNumber')->on('employees')->nullOnDelete();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->integer('orderNumber')->primary();
            $table->date('orderDate');
            $table->date('requiredDate');
            $table->date('shippedDate')->nullable();
            $table->string('status', 15);
            $table->text('comments')->nullable();
            $table->integer('customerNumber');
            $table->foreign('customerNumber')->references('customerNumber')->on('customers');
        });

        Schema::create('orderdetails', function (Blueprint $table) {
            $table->integer('orderNumber');
            $table->string('productCode', 15);
            $table->integer('quantityOrdered');
            $table->decimal('priceEach', 10, 2);
            $table->smallInteger('orderLineNumber');
            $table->primary(['orderNumber', 'productCode']);
            $table->foreign('orderNumber')->references('orderNumber')->on('orders');
            $table->foreign('productCode')->references('productCode')->on('products');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->integer('customerNumber');
            $table->string('checkNumber', 50);
            $table->date('paymentDate');
            $table->decimal('amount', 10, 2);
            $table->primary(['customerNumber', 'checkNumber']);
            $table->foreign('customerNumber')->references('customerNumber')->on('customers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('orderdetails');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('products');
        Schema::dropIfExists('productlines');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('offices');
    }
};
