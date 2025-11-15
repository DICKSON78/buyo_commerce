<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            // Personal Information
            $table->string('full_name')->nullable()->after('id');
            $table->string('email')->nullable()->after('full_name');
            $table->string('phone')->nullable()->after('email');
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->enum('gender', ['male', 'female'])->nullable()->after('date_of_birth');

            // Location Information
            $table->string('location')->nullable()->after('gender');
            $table->string('region')->nullable()->after('location');
            $table->string('address')->nullable()->after('region');
            $table->string('city')->nullable()->after('address');
            $table->string('country')->default('Tanzania')->after('city');

            // Customer Stats & Preferences
            $table->integer('total_orders')->default(0)->after('country');
            $table->decimal('total_spent', 12, 2)->default(0.00)->after('total_orders');
            $table->integer('pending_orders')->default(0)->after('total_spent');
            $table->integer('completed_orders')->default(0)->after('pending_orders');
            $table->integer('cancelled_orders')->default(0)->after('completed_orders');
            $table->integer('support_tickets')->default(0)->after('cancelled_orders');

            // Preferences
            $table->string('preferred_payment_method')->nullable()->after('support_tickets');
            $table->string('preferred_shipping_method')->nullable()->after('preferred_payment_method');
            $table->boolean('newsletter_subscribed')->default(false)->after('preferred_shipping_method');
            $table->boolean('marketing_emails')->default(false)->after('newsletter_subscribed');
            $table->boolean('sms_notifications')->default(true)->after('marketing_emails');

            // Profile Completion
            $table->integer('profile_completion')->default(0)->after('sms_notifications');
            $table->timestamp('last_login_at')->nullable()->after('profile_completion');
            $table->timestamp('email_verified_at')->nullable()->after('last_login_at');
            $table->string('verification_token')->nullable()->after('email_verified_at');

            // Social & Additional Info
            $table->string('profile_picture')->nullable()->after('verification_token');
            $table->text('bio')->nullable()->after('profile_picture');
            $table->json('preferences')->nullable()->after('bio');

            // Timestamps already exist from original migration
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'full_name',
                'email',
                'phone',
                'date_of_birth',
                'gender',
                'location',
                'region',
                'address',
                'city',
                'country',
                'total_orders',
                'total_spent',
                'pending_orders',
                'completed_orders',
                'cancelled_orders',
                'support_tickets',
                'preferred_payment_method',
                'preferred_shipping_method',
                'newsletter_subscribed',
                'marketing_emails',
                'sms_notifications',
                'profile_completion',
                'last_login_at',
                'email_verified_at',
                'verification_token',
                'profile_picture',
                'bio',
                'preferences'
            ]);
        });
    }
};
