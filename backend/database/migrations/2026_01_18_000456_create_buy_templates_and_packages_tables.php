<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //create customers table
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('customer_id');
            $table->string('session_id', 64); // link back to responses
            $table->string('full_name', 150);
            $table->string('email', 150);
            $table->string('phone', 20);
            $table->text('address');
            $table->enum('purchase_intent', ['YES', 'NO']);
            $table->timestamps(); // created_at & updated_at
        });
        //create customer_responses table
        Schema::create('customer_responses', function (Blueprint $table) {
            $table->bigIncrements('response_id');
            $table->string('session_id', 64);
            $table->integer('step_number');
            $table->text('question_text');
            $table->string('option_text', 255);
            $table->text('response_text');
            $table->timestamps();
        });
        //create orders table
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('order_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('template_name', 150);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['Pending', 'Paid', 'Completed', 'Cancelled'])->default('Pending');
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('customer_id')
                ->on('customers')
                ->onDelete('cascade');
        });
        //create uploaded_documents table
        Schema::create('uploaded_documents', function (Blueprint $table) {
            $table->bigIncrements('doc_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('file_name', 255);
            $table->string('file_type', 100);
            $table->mediumBlob('file_data'); // maps to MEDIUMBLOB in MariaDB
            $table->timestamps(); // uploaded_at & updated_at

            $table->foreign('customer_id')
                ->references('customer_id')
                ->on('customers')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploaded_documents');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('customer_responses');
        Schema::dropIfExists('customers');
    }
};
