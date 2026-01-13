<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visa_applications', function (Blueprint $table) {
            $table->bigIncrements('application_id');
            $table->string('visa_country', 50)->default('UK');
            $table->string('visa_type', 100);

            $table->boolean('has_dependents')->default(false);
            $table->boolean('has_deadline')->default(false);
            $table->boolean('has_previous_issues')->default(false);
            $table->boolean('has_previous_uk_visa')->default(false);
            $table->boolean('has_sponsor')->default(false);
            $table->boolean('has_selected_recommended_package')->default(true);

            $table->enum('application_status', [
                'IN_PROGRESS',
                'PACKAGE_SELECTED',
                'PAYMENT_PENDING',
                'PAID',
                'ABANDONED'
            ])->default('IN_PROGRESS');

            $table->timestamps(); // creates created_at and updated_at
        });


        Schema::create('visa_dependents', function (Blueprint $table) {
            $table->bigIncrements('dependent_id');
            
            $table->unsignedBigInteger('application_id');
            $table->string('full_name', 150);
            $table->enum('relationship', ['Partner', 'Child', 'Adult Relative']);
            $table->date('date_of_birth');
            $table->string('nationality', 100);
            $table->string('passport_number', 50);

            $table->timestamps(); // creates created_at and updated_at

            // Foreign key constraint
            $table->foreign('application_id')
                  ->references('application_id')
                  ->on('visa_applications')
                  ->onDelete('cascade');
        });


        Schema::create('visa_deadlines', function (Blueprint $table) {
            $table->bigIncrements('deadline_id');

            $table->unsignedBigInteger('application_id');
            $table->date('deadline_date');
            $table->string('reason', 255)->nullable();
            $table->text('additional_details')->nullable();

            $table->timestamps(); // creates created_at and updated_at

            // Foreign key constraint
            $table->foreign('application_id')
                  ->references('application_id')
                  ->on('visa_applications')
                  ->onDelete('cascade');
        });

        Schema::create('visa_previous_issues', function (Blueprint $table) {
            $table->bigIncrements('issue_id');

            $table->unsignedBigInteger('application_id');
            $table->string('issue_type', 100);
            $table->date('issue_date');
            $table->string('country', 100);
            $table->text('description')->nullable();
            $table->enum('resolution_status', ['Resolved', 'Pending', 'Rejected'])->nullable();

            $table->timestamps(); // creates created_at and updated_at

            // Foreign key constraint
            $table->foreign('application_id')
                  ->references('application_id')
                  ->on('visa_applications')
                  ->onDelete('cascade');
        });

        Schema::create('visa_previous_uk_visas', function (Blueprint $table) {
            $table->bigIncrements('previous_visa_id');

            $table->unsignedBigInteger('application_id');
            $table->string('visa_type', 100)->nullable();
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->string('visa_number', 50);
            $table->text('purpose_of_visit')->nullable();
            $table->text('issues')->nullable();

            $table->timestamps();  // creates created_at and updated_at

            // Foreign key constraint
            $table->foreign('application_id')
                  ->references('application_id')
                  ->on('visa_applications')
                  ->onDelete('cascade');
        });


        Schema::create('visa_sponsors', function (Blueprint $table) {
            $table->bigIncrements('sponsor_id');

            $table->unsignedBigInteger('application_id');
            $table->string('sponsor_type', 100);
            $table->string('sponsor_name', 150);
            $table->string('sponsor_email', 150);
            $table->string('sponsor_phone', 50);
            $table->text('sponsor_address');
            $table->text('sponsor_details')->nullable();

            $table->timestamps(); // creates created_at and updated_at

            // Foreign key constraint
            $table->foreign('application_id')
                  ->references('application_id')
                  ->on('visa_applications')
                  ->onDelete('cascade');
        });


        Schema::create('visa_packages', function (Blueprint $table) {
            $table->bigIncrements('package_id');
            $table->unsignedBigInteger('application_id');
            $table->string('package_name', 150);
            $table->string('visa_type', 100);
            $table->decimal('base_price', 10, 2);
            $table->timestamps(); // adds created_at and updated_at
        });

        Schema::create('message_credit_options', function (Blueprint $table) {
            $table->bigIncrements('credit_id');
            $table->unsignedBigInteger('application_id');
            $table->integer('credits');
            $table->decimal('price', 10, 2);

            $table->timestamps(); // adds created_at and updated_at
        });

        Schema::create('application_packages', function (Blueprint $table) {
            $table->bigIncrements('app_package_id');

            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('credit_id');

            $table->decimal('total_price', 10, 2);
            $table->timestamps(); // adds created_at and updated_at

            // Foreign keys
            $table->foreign('application_id')
                  ->references('application_id')
                  ->on('visa_applications')
                  ->onDelete('cascade');

            $table->foreign('package_id')
                  ->references('package_id')
                  ->on('visa_packages')
                  ->onDelete('cascade');

            $table->foreign('credit_id')
                  ->references('credit_id')
                  ->on('message_credit_options')
                  ->onDelete('cascade');
        });

        Schema::create('applicant_contact_details', function (Blueprint $table) {
            $table->bigIncrements('contact_id');

            $table->unsignedBigInteger('application_id');
            $table->string('full_name', 150);
            $table->string('email', 150);
            $table->string('contact_number', 50);
            $table->string('preferred_contact_time', 50);
            $table->text('additional_notes')->nullable();

            $table->timestamps(); // creates created_at and updated_at

            // Foreign key
            $table->foreign('application_id')
                  ->references('application_id')
                  ->on('visa_applications')
                  ->onDelete('cascade');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('payment_id');

            $table->unsignedBigInteger('application_id');
            $table->enum('payment_method', ['PAYPAL_GUEST', 'PAYPAL_ACCOUNT', 'PAY_LATER']);
            $table->enum('payment_status', ['INITIATED', 'PAID', 'FAILED', 'EMAIL_SENT']);

            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('GBP');
            $table->string('transaction_reference', 100);

            $table->timestamps(); // creates created_at and updated_at

            // Foreign key
            $table->foreign('application_id')
                  ->references('application_id')
                  ->on('visa_applications')
                  ->onDelete('cascade');
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_applications');
        Schema::dropIfExists('visa_dependents');
        Schema::dropIfExists('visa_deadlines');
        Schema::dropIfExists('visa_previous_issues');
        Schema::dropIfExists('visa_previous_uk_visas');
        Schema::dropIfExists('visa_sponsors');
        Schema::dropIfExists('visa_packages');
        Schema::dropIfExists('message_credit_options');
        Schema::dropIfExists('application_packages');
        Schema::dropIfExists('applicant_contact_details');
        Schema::dropIfExists('payments');
    }
};