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
        // Step 1: Primary Applicant
        Schema::create('primary_applicant', function (Blueprint $table) {
            $table->bigIncrements('applicant_id');
            $table->unsignedBigInteger('application_id');
            $table->string('full_name', 150);
            $table->string('email', 150);
            $table->string('phone_number', 20);
            $table->timestamps();

            $table->foreign('application_id')
                ->references('application_id')
                ->on('visa_applications')
                ->onDelete('cascade');
        });

        // Step 2: Eligibility Information
        Schema::create('eligibility_info', function (Blueprint $table) {
            $table->bigIncrements('eligibility_id');
            $table->unsignedBigInteger('application_id');
            $table->string('email', 150);
            $table->string('nationality', 100);
            $table->date('date_of_birth');
            $table->timestamps();

            $table->foreign('application_id')
                ->references('application_id')
                ->on('visa_applications')
                ->onDelete('cascade');
        });

        // Step 3: Personal Information
        Schema::create('personal_info', function (Blueprint $table) {
            $table->bigIncrements('personal_info_id');
            $table->unsignedBigInteger('application_id');
            $table->string('full_name', 150);
            $table->string('primary_phone', 20);
            $table->string('alternate_phone', 20)->nullable();
            $table->string('email', 150);
            $table->string('street_address', 255);
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('postal_code', 20);
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->timestamps();

            $table->foreign('application_id')
                ->references('application_id')
                ->on('visa_applications')
                ->onDelete('cascade');
        });

        // Step 4: Employment Information
        Schema::create('employment_info', function (Blueprint $table) {
            $table->bigIncrements('employment_id');
            $table->unsignedBigInteger('application_id');
            $table->string('employer', 150);
            $table->string('job_title', 100);
            $table->string('work_address', 255);
            $table->string('work_phone', 20);
            $table->integer('years_at_job');
            $table->enum('employment_status', ['Employed', 'Unemployed', 'Student', 'Retired', 'Self-Employed', 'Other']);
            $table->decimal('annual_income', 12, 2);
            $table->timestamps();

            $table->foreign('application_id')
                ->references('application_id')
                ->on('visa_applications')
                ->onDelete('cascade');
        });

        // Step 5: Travel Information
        Schema::create('travel_info', function (Blueprint $table) {
            $table->bigIncrements('travel_id');
            $table->unsignedBigInteger('application_id');
            $table->string('destination_country', 100);
            $table->date('departure_date');
            $table->date('return_date');
            $table->string('purpose_of_travel', 150);
            $table->text('accommodation_details');
            $table->timestamps();

            $table->foreign('application_id')
                ->references('application_id')
                ->on('visa_applications')
                ->onDelete('cascade');
        });

        // Step 6: Additional Applicants
        Schema::create('additional_applicants', function (Blueprint $table) {
            $table->bigIncrements('additional_applicant_id');
            $table->unsignedBigInteger('application_id');
            $table->string('full_name', 150);
            $table->string('email', 150);
            $table->string('phone', 20);
            $table->date('date_of_birth');
            $table->string('nationality', 100);
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('relationship', 50);
            $table->timestamps();

            $table->foreign('application_id')
                ->references('application_id')
                ->on('visa_applications')
                ->onDelete('cascade');
        });

        // Step 6a: Additional Applicant Employment
        Schema::create('additional_employment_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('additional_applicant_id');
            $table->string('employer', 150);
            $table->string('job_title', 100);
            $table->string('work_address', 255);
            $table->string('work_phone', 20);
            $table->integer('years_at_job');
            $table->enum('employment_status', ['Employed', 'Unemployed', 'Student', 'Retired', 'Self-Employed', 'Other']);
            $table->string('annual_income_range', 50);
            $table->decimal('exact_annual_income', 12, 2);
            $table->string('education_level', 50);
            $table->string('english_proficiency', 50);
            $table->timestamps();

            $table->foreign('additional_applicant_id')
                ->references('additional_applicant_id')
                ->on('additional_applicants')
                ->onDelete('cascade');
        });

        // Step 6b: Additional Applicant Travel
        Schema::create('additional_travel_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('additional_applicant_id');
            $table->string('destination_country', 100);
            $table->date('departure_date');
            $table->date('return_date');
            $table->string('purpose_of_travel', 150);
            $table->string('accommodation_type', 50);
            $table->text('accommodation_details');
            $table->timestamps();

            $table->foreign('additional_applicant_id')
                ->references('additional_applicant_id')
                ->on('additional_applicants')
                ->onDelete('cascade');
        });

        // Step 7: Document Uploads
        Schema::create('visa_documents', function (Blueprint $table) {
            $table->bigIncrements('document_id');
            $table->unsignedBigInteger('application_id');
            $table->enum('applicant_type', ['PRIMARY', 'ADDITIONAL']);
            $table->unsignedBigInteger('applicant_id');
            $table->enum('document_type', ['Passport', 'Visa', 'Birth Certificate', 'Marriage Certificate', 'Bank Statement', 'Employment Letter', 'Other']);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('application_id')
                ->references('application_id')
                ->on('visa_applications')
                ->onDelete('cascade');
        });

        // Child table of Document to store multiple files of an applicant
        // Document files table
        Schema::create('visa_document_files', function (Blueprint $table) {
            $table->bigIncrements('file_id');
            $table->unsignedBigInteger('document_id');
            $table->string('file_name', 255);
            $table->string('file_type', 100); // e.g. pdf, jpg, png
            $table->mediumBlob('file_data');  // maps to MEDIUMBLOB in MariaDB
            $table->dateTime('uploaded_at')->useCurrent();

            // Foreign key constraint
            $table->foreign('document_id')
                ->references('document_id')
                ->on('visa_documents')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('primary_applicant');
        Schema::dropIfExists('eligibility_info');
        Schema::dropIfExists('personal_info');
        Schema::dropIfExists('employment_info');
        Schema::dropIfExists('travel_info');
        Schema::dropIfExists('additional_employment_info');
        Schema::dropIfExists('additional_travel_info');
        Schema::dropIfExists('additional_applicants');
        Schema::dropIfExists('visa_document_files');
        Schema::dropIfExists('visa_documents');
        Schema::dropIfExists('application_audit');
    }
};
