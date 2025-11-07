<?php

// This script generates Laravel migrations, models, controllers, and routes based on the schema.
// Run it with php generate_laravel.php in your Laravel project root.
// It will create files in the appropriate directories and overwrite existing files.

$basePath = getcwd();

// Create directories if not exist
$dirs = [
    $basePath . '/database/migrations',
    $basePath . '/app/Models',
    $basePath . '/app/Http/Controllers',
    $basePath . '/routes',
];
foreach ($dirs as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Migrations
$timestamp = date('Y_m_d_His', strtotime('2025-10-17 11:40:00')); // Fixed timestamp for consistency

// Users Table
file_put_contents("database/migrations/{$timestamp}_create_users_table.php", '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(\'users\', function (Blueprint $table) {
            $table->id();
            $table->string(\'name\', 255)->nullable(false);
            $table->string(\'email\', 255)->unique()->nullable();
            $table->string(\'phone\', 20)->unique()->nullable();
            $table->string(\'password\', 255)->nullable(false);
            $table->enum(\'role\', [\'buyer\', \'seller\', \'admin\'])->default(\'buyer\');
            $table->string(\'avatar\', 500)->nullable();
            $table->timestamp(\'email_verified_at\')->nullable();
            $table->timestamp(\'phone_verified_at\')->nullable();
            $table->boolean(\'is_active\')->default(true);
            $table->enum(\'language\', [\'en\', \'sw\'])->default(\'en\');
            $table->timestamps(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\'users\');
    }
};
');

// Seller Profiles Table
file_put_contents("database/migrations/{$timestamp}_create_seller_profiles_table.php", '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(\'seller_profiles\', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(\'user_id\')->nullable(false);
            $table->string(\'store_name\', 255)->nullable(false);
            $table->string(\'store_slug\', 255)->unique()->nullable(false);
            $table->string(\'store_logo\', 500)->nullable();
            $table->text(\'bio\')->nullable();
            $table->string(\'contact_phone\', 20)->nullable();
            $table->string(\'contact_email\', 255)->nullable();
            $table->string(\'location\', 255)->nullable();
            $table->text(\'address\')->nullable();
            $table->enum(\'verified_status\', [\'pending\', \'verified\', \'rejected\'])->default(\'pending\');
            $table->decimal(\'rating\', 3, 2)->default(0.00);
            $table->integer(\'total_sales\')->default(0);
            $table->timestamps(false);
            $table->foreign(\'user_id\')->references(\'id\')->on(\'users\')->onDelete(\'cascade\');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\'seller_profiles\');
    }
};
');

// OTP Verifications Table
file_put_contents("database/migrations/{$timestamp}_create_otp_verifications_table.php", '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(\'otp_verifications\', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(\'user_id\')->nullable();
            $table->string(\'phone\', 20)->nullable();
            $table->string(\'email\', 255)->nullable();
            $table->string(\'otp_code\', 10)->nullable(false);
            $table->string(\'token\', 255)->nullable(false);
            $table->enum(\'type\', [\'phone_verification\', \'email_verification\', \'password_reset\'])->nullable(false);
            $table->boolean(\'is_used\')->default(false);
            $table->timestamp(\'expires_at\')->nullable(false);
            $table->timestamps();
            $table->foreign(\'user_id\')->references(\'id\')->on(\'users\')->onDelete(\'set null\');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\'otp_verifications\');
    }
};
');

// Categories Table
file_put_contents("database/migrations/{$timestamp}_create_categories_table.php", '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(\'categories\', function (Blueprint $table) {
            $table->id();
            $table->string(\'name\', 255)->nullable(false);
            $table->string(\'name_sw\', 255)->nullable();
            $table->string(\'slug\', 255)->unique()->nullable(false);
            $table->text(\'description\')->nullable();
            $table->unsignedBigInteger(\'parent_id\')->nullable();
            $table->string(\'image\', 500)->nullable();
            $table->string(\'icon\', 100)->nullable();
            $table->boolean(\'is_active\')->default(true);
            $table->integer(\'sort_order\')->default(0);
            $table->timestamps();
            $table->foreign(\'parent_id\')->references(\'id\')->on(\'categories\')->onDelete(\'set null\');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\'categories\');
    }
};
');

// Products Table
file_put_contents("database/migrations/{$timestamp}_create_products_table.php", '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(\'products\', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(\'seller_id\')->nullable(false);
            $table->unsignedBigInteger(\'category_id\')->nullable(false);
            $table->string(\'name\', 255)->nullable(false);
            $table->string(\'name_sw\', 255)->nullable();
            $table->string(\'slug\', 255)->unique()->nullable(false);
            $table->text(\'description\')->nullable();
            $table->text(\'description_sw\')->nullable();
            $table->decimal(\'price\', 10, 2)->nullable(false);
            $table->decimal(\'compare_price\', 10, 2)->nullable();
            $table->integer(\'quantity\')->default(1);
            $table->string(\'sku\', 100)->nullable();
            $table->enum(\'condition\', [\'new\', \'used\', \'refurbished\'])->default(\'new\');
            $table->enum(\'status\', [\'draft\', \'active\', \'inactive\', \'sold\'])->default(\'draft\');
            $table->boolean(\'is_featured\')->default(false);
            $table->boolean(\'is_approved\')->default(false);
            $table->unsignedBigInteger(\'approved_by\')->nullable();
            $table->timestamp(\'approved_at\')->nullable();
            $table->integer(\'view_count\')->default(0);
            $table->string(\'location\', 255)->nullable();
            $table->decimal(\'latitude\', 10, 8)->nullable();
            $table->decimal(\'longitude\', 11, 8)->nullable();
            $table->timestamps();
            $table->foreign(\'seller_id\')->references(\'user_id\')->on(\'seller_profiles\')->onDelete(\'cascade\');
            $table->foreign(\'category_id\')->references(\'id\')->on(\'categories\')->onDelete(\'restrict\');
            $table->foreign(\'approved_by\')->references(\'id\')->on(\'users\')->onDelete(\'set null\');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\'products\');
    }
};
');

// Product Images Table
file_put_contents("database/migrations/{$timestamp}_create_product_images_table.php", '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(\'product_images\', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(\'product_id\')->nullable(false);
            $table->string(\'image_path\', 500)->nullable(false);
            $table->boolean(\'is_primary\')->default(false);
            $table->integer(\'sort_order\')->default(0);
            $table->timestamps();
            $table->foreign(\'product_id\')->references(\'id\')->on(\'products\')->onDelete(\'cascade\');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\'product_images\');
    }
};
');

// Conversations Table
file_put_contents("database/migrations/{$timestamp}_create_conversations_table.php", '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(\'conversations\', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(\'product_id\')->nullable();
            $table->unsignedBigInteger(\'buyer_id\')->nullable(false);
            $table->unsignedBigInteger(\'seller_id\')->nullable(false);
            $table->text(\'last_message\')->nullable();
            $table->timestamp(\'last_message_at\')->nullable();
            $table->boolean(\'buyer_deleted\')->default(false);
            $table->boolean(\'seller_deleted\')->default(false);
            $table->timestamps();
            $table->foreign(\'product_id\')->references(\'id\')->on(\'products\')->onDelete(\'set null\');
            $table->foreign(\'buyer_id\')->references(\'id\')->on(\'users\')->onDelete(\'cascade\');
            $table->foreign(\'seller_id\')->references(\'id\')->on(\'users\')->onDelete(\'cascade\');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\'conversations\');
    }
};
');

// Messages Table
file_put_contents("database/migrations/{$timestamp}_create_messages_table.php", '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(\'messages\', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(\'conversation_id\')->nullable(false);
            $table->unsignedBigInteger(\'sender_id\')->nullable(false);
            $table->enum(\'message_type\', [\'text\', \'image\', \'file\'])->default(\'text\');
            $table->text(\'message\')->nullable(false);
            $table->string(\'attachment_path\', 500)->nullable();
            $table->boolean(\'is_read\')->default(false);
            $table->timestamp(\'read_at\')->nullable();
            $table->timestamps();
            $table->foreign(\'conversation_id\')->references(\'id\')->on(\'conversations\')->onDelete(\'cascade\');
            $table->foreign(\'sender_id\')->references(\'id\')->on(\'users\')->onDelete(\'cascade\');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\'messages\');
    }
};
');

// Favorites Table
file_put_contents("database/migrations/{$timestamp}_create_favorites_table.php", '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(\'favorites\', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(\'user_id\')->nullable(false);
            $table->unsignedBigInteger(\'product_id\')->nullable(false);
            $table->timestamps();
            $table->foreign(\'user_id\')->references(\'id\')->on(\'users\')->onDelete(\'cascade\');
            $table->foreign(\'product_id\')->references(\'id\')->on(\'products\')->onDelete(\'cascade\');
            $table->unique([\'user_id\', \'product_id\']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\'favorites\');
    }
};
');

// Product Views Table
file_put_contents("database/migrations/{$timestamp}_create_product_views_table.php", '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(\'product_views\', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(\'product_id\')->nullable(false);
            $table->unsignedBigInteger(\'user_id\')->nullable();
            $table->string(\'ip_address\', 45)->nullable(false);
            $table->text(\'user_agent\')->nullable();
            $table->timestamps();
            $table->foreign(\'product_id\')->references(\'id\')->on(\'products\')->onDelete(\'cascade\');
            $table->foreign(\'user_id\')->references(\'id\')->on(\'users\')->onDelete(\'set null\');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\'product_views\');
    }
};
');

// Orders Table
file_put_contents("database/migrations/{$timestamp}_create_orders_table.php", '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(\'orders\', function (Blueprint $table) {
            $table->id();
            $table->string(\'order_number\', 50)->unique()->nullable(false);
            $table->unsignedBigInteger(\'buyer_id\')->nullable(false);
            $table->unsignedBigInteger(\'seller_id\')->nullable(false);
            $table->unsignedBigInteger(\'product_id\')->nullable(false);
            $table->integer(\'quantity\')->nullable(false);
            $table->decimal(\'unit_price\', 10, 2)->nullable(false);
            $table->decimal(\'total_price\', 10, 2)->nullable(false);
            $table->enum(\'status\', [\'pending\', \'confirmed\', \'shipped\', \'delivered\', \'cancelled\'])->default(\'pending\');
            $table->text(\'buyer_note\')->nullable();
            $table->text(\'seller_note\')->nullable();
            $table->enum(\'cancelled_by\', [\'buyer\', \'seller\', \'admin\'])->nullable();
            $table->text(\'cancellation_reason\')->nullable();
            $table->timestamps();
            $table->foreign(\'buyer_id\')->references(\'id\')->on(\'users\')->onDelete(\'cascade\');
            $table->foreign(\'seller_id\')->references(\'id\')->on(\'users\')->onDelete(\'cascade\');
            $table->foreign(\'product_id\')->references(\'id\')->on(\'products\')->onDelete(\'cascade\');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\'orders\');
    }
};
');

// Order Histories Table
file_put_contents("database/migrations/{$timestamp}_create_order_histories_table.php", '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(\'order_histories\', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(\'order_id\')->nullable(false);
            $table->enum(\'status\', [\'pending\', \'confirmed\', \'shipped\', \'delivered\', \'cancelled\'])->nullable(false);
            $table->text(\'note\')->nullable();
            $table->unsignedBigInteger(\'created_by\')->nullable();
            $table->timestamps();
            $table->foreign(\'order_id\')->references(\'id\')->on(\'orders\')->onDelete(\'cascade\');
            $table->foreign(\'created_by\')->references(\'id\')->on(\'users\')->onDelete(\'set null\');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\'order_histories\');
    }
};
');

// System Settings Table
file_put_contents("database/migrations/{$timestamp}_create_system_settings_table.php", '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(\'system_settings\', function (Blueprint $table) {
            $table->id();
            $table->string(\'setting_key\', 255)->unique()->nullable(false);
            $table->text(\'setting_value\')->nullable(false);
            $table->enum(\'setting_type\', [\'string\', \'integer\', \'boolean\', \'json\'])->default(\'string\');
            $table->text(\'description\')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\'system_settings\');
    }
};
');

// Reports Table
file_put_contents("database/migrations/{$timestamp}_create_reports_table.php", '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(\'reports\', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(\'reporter_id\')->nullable(false);
            $table->unsignedBigInteger(\'reported_user_id\')->nullable();
            $table->unsignedBigInteger(\'reported_product_id\')->nullable();
            $table->enum(\'report_type\', [\'user\', \'product\', \'message\'])->nullable(false);
            $table->text(\'reason\')->nullable(false);
            $table->enum(\'status\', [\'pending\', \'reviewed\', \'resolved\'])->default(\'pending\');
            $table->text(\'admin_notes\')->nullable();
            $table->unsignedBigInteger(\'resolved_by\')->nullable();
            $table->timestamp(\'resolved_at\')->nullable();
            $table->timestamps();
            $table->foreign(\'reporter_id\')->references(\'id\')->on(\'users\')->onDelete(\'cascade\');
            $table->foreign(\'reported_user_id\')->references(\'id\')->on(\'users\')->onDelete(\'set null\');
            $table->foreign(\'reported_product_id\')->references(\'id\')->on(\'products\')->onDelete(\'set null\');
            $table->foreign(\'resolved_by\')->references(\'id\')->on(\'users\')->onDelete(\'set null\');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\'reports\');
    }
};
');

// Notifications Table
file_put_contents("database/migrations/{$timestamp}_create_notifications_table.php", '<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(\'notifications\', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(\'user_id\')->nullable(false);
            $table->string(\'title\', 255)->nullable(false);
            $table->text(\'message\')->nullable(false);
            $table->enum(\'type\', [\'info\', \'success\', \'warning\', \'error\'])->default(\'info\');
            $table->enum(\'related_type\', [\'order\', \'message\', \'product\', \'system\'])->nullable();
            $table->unsignedBigInteger(\'related_id\')->nullable();
            $table->boolean(\'is_read\')->default(false);
            $table->timestamp(\'read_at\')->nullable();
            $table->timestamps();
            $table->foreign(\'user_id\')->references(\'id\')->on(\'users\')->onDelete(\'cascade\');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(\'notifications\');
    }
};
');

// Models
file_put_contents('app/Models/User.php', '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [\'name\', \'email\', \'phone\', \'password\', \'role\', \'avatar\', \'email_verified_at\', \'phone_verified_at\', \'is_active\', \'language\'];
    protected $casts = [
        \'is_active\' => \'boolean\',
        \'email_verified_at\' => \'datetime\',
        \'phone_verified_at\' => \'datetime\',
    ];

    public function sellerProfile()
    {
        return $this->hasOne(SellerProfile::class);
    }

    public function otpVerifications()
    {
        return $this->hasMany(OtpVerification::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, SellerProfile::class, \'user_id\', \'seller_id\', \'id\', \'id\');
    }

    public function conversationsAsBuyer()
    {
        return $this->hasMany(Conversation::class, \'buyer_id\', \'id\');
    }

    public function conversationsAsSeller()
    {
        return $this->hasMany(Conversation::class, \'seller_id\', \'id\');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, \'sender_id\', \'id\');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, \'user_id\', \'id\');
    }

    public function productViews()
    {
        return $this->hasMany(ProductView::class, \'user_id\', \'id\');
    }

    public function ordersAsBuyer()
    {
        return $this->hasMany(Order::class, \'buyer_id\', \'id\');
    }

    public function ordersAsSeller()
    {
        return $this->hasMany(Order::class, \'seller_id\', \'id\');
    }

    public function orderHistories()
    {
        return $this->hasMany(OrderHistory::class, \'created_by\', \'id\');
    }

    public function reportsAsReporter()
    {
        return $this->hasMany(Report::class, \'reporter_id\', \'id\');
    }

    public function reportsAsReportedUser()
    {
        return $this->hasMany(Report::class, \'reported_user_id\', \'id\');
    }

    public function reportsAsResolver()
    {
        return $this->hasMany(Report::class, \'resolved_by\', \'id\');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, \'user_id\', \'id\');
    }
}
');

file_put_contents('app/Models/SellerProfile.php', '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProfile extends Model
{
    use HasFactory;

    protected $fillable = [\'user_id\', \'store_name\', \'store_slug\', \'store_logo\', \'bio\', \'contact_phone\', \'contact_email\', \'location\', \'address\', \'verified_status\', \'rating\', \'total_sales\'];
    protected $casts = [
        \'rating\' => \'decimal:3,2\',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, \'seller_id\', \'id\');
    }
}
');

file_put_contents('app/Models/OtpVerification.php', '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    use HasFactory;

    protected $fillable = [\'user_id\', \'phone\', \'email\', \'otp_code\', \'token\', \'type\', \'is_used\', \'expires_at\'];
    protected $casts = [
        \'is_used\' => \'boolean\',
        \'expires_at\' => \'datetime\',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
');

file_put_contents('app/Models/Category.php', '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [\'name\', \'name_sw\', \'slug\', \'description\', \'parent_id\', \'image\', \'icon\', \'is_active\', \'sort_order\'];
    protected $casts = [
        \'is_active\' => \'boolean\',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, \'parent_id\', \'id\');
    }

    public function children()
    {
        return $this->hasMany(Category::class, \'parent_id\', \'id\');
    }

    public function products()
    {
        return $this->hasMany(Product::class, \'category_id\', \'id\');
    }
}
');

file_put_contents('app/Models/Product.php', '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [\'seller_id\', \'category_id\', \'name\', \'name_sw\', \'slug\', \'description\', \'description_sw\', \'price\', \'compare_price\', \'quantity\', \'sku\', \'condition\', \'status\', \'is_featured\', \'is_approved\', \'approved_by\', \'approved_at\', \'view_count\', \'location\', \'latitude\', \'longitude\'];
    protected $casts = [
        \'price\' => \'decimal:10,2\',
        \'compare_price\' => \'decimal:10,2\',
        \'quantity\' => \'integer\',
        \'is_featured\' => \'boolean\',
        \'is_approved\' => \'boolean\',
        \'approved_at\' => \'datetime\',
        \'latitude\' => \'decimal:10,8\',
        \'longitude\' => \'decimal:11,8\',
    ];

    public function seller()
    {
        return $this->belongsTo(SellerProfile::class, \'seller_id\', \'id\');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, \'category_id\', \'id\');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, \'approved_by\', \'id\');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, \'product_id\', \'id\');
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class, \'product_id\', \'id\');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, \'product_id\', \'id\');
    }

    public function productViews()
    {
        return $this->hasMany(ProductView::class, \'product_id\', \'id\');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, \'product_id\', \'id\');
    }
}
');

file_put_contents('app/Models/ProductImage.php', '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [\'product_id\', \'image_path\', \'is_primary\', \'sort_order\'];
    protected $casts = [
        \'is_primary\' => \'boolean\',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
');

file_put_contents('app/Models/Conversation.php', '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [\'product_id\', \'buyer_id\', \'seller_id\', \'last_message\', \'last_message_at\', \'buyer_deleted\', \'seller_deleted\'];
    protected $casts = [
        \'buyer_deleted\' => \'boolean\',
        \'seller_deleted\' => \'boolean\',
        \'last_message_at\' => \'datetime\',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, \'buyer_id\', \'id\');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, \'seller_id\', \'id\');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, \'conversation_id\', \'id\');
    }
}
');

file_put_contents('app/Models/Message.php', '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [\'conversation_id\', \'sender_id\', \'message_type\', \'message\', \'attachment_path\', \'is_read\', \'read_at\'];
    protected $casts = [
        \'is_read\' => \'boolean\',
        \'read_at\' => \'datetime\',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, \'sender_id\', \'id\');
    }
}
');

file_put_contents('app/Models/Favorite.php', '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [\'user_id\', \'product_id\'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
');

file_put_contents('app/Models/ProductView.php', '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
    use HasFactory;

    protected $fillable = [\'product_id\', \'user_id\', \'ip_address\', \'user_agent\'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
');

file_put_contents('app/Models/Order.php', '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [\'order_number\', \'buyer_id\', \'seller_id\', \'product_id\', \'quantity\', \'unit_price\', \'total_price\', \'status\', \'buyer_note\', \'seller_note\', \'cancelled_by\', \'cancellation_reason\'];
    protected $casts = [
        \'unit_price\' => \'decimal:10,2\',
        \'total_price\' => \'decimal:10,2\',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, \'buyer_id\', \'id\');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, \'seller_id\', \'id\');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderHistories()
    {
        return $this->hasMany(OrderHistory::class, \'order_id\', \'id\');
    }
}
');

file_put_contents('app/Models/OrderHistory.php', '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    protected $fillable = [\'order_id\', \'status\', \'note\', \'created_by\'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, \'created_by\', \'id\');
    }
}
');

file_put_contents('app/Models/SystemSetting.php', '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [\'setting_key\', \'setting_value\', \'setting_type\', \'description\'];
}
');

file_put_contents('app/Models/Report.php', '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [\'reporter_id\', \'reported_user_id\', \'reported_product_id\', \'report_type\', \'reason\', \'status\', \'admin_notes\', \'resolved_by\', \'resolved_at\'];
    protected $casts = [
        \'resolved_at\' => \'datetime\',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, \'reporter_id\', \'id\');
    }

    public function reportedUser()
    {
        return $this->belongsTo(User::class, \'reported_user_id\', \'id\');
    }

    public function reportedProduct()
    {
        return $this->belongsTo(Product::class, \'reported_product_id\', \'id\');
    }

    public function resolver()
    {
        return $this->belongsTo(User::class, \'resolved_by\', \'id\');
    }
}
');

file_put_contents('app/Models/Notification.php', '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [\'user_id\', \'title\', \'message\', \'type\', \'related_type\', \'related_id\', \'is_read\', \'read_at\'];
    protected $casts = [
        \'is_read\' => \'boolean\',
        \'read_at\' => \'datetime\',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
');

// Controllers
file_put_contents('app/Http/Controllers/UserController.php', '<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            \'name\' => \'required|string|max:255\',
            \'email\' => \'nullable|email|unique:users,email\',
            \'phone\' => \'nullable|string|max:20|unique:users,phone\',
            \'password\' => \'required|string|min:8\',
            \'role\' => \'required|in:buyer,seller,admin\',
        ]);

        return User::create($validated);
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            \'name\' => \'sometimes|string|max:255\',
            \'email\' => \'sometimes|email|unique:users,email,\' . $user->id,
            \'phone\' => \'sometimes|string|max:20|unique:users,phone,\' . $user->id,
            \'password\' => \'sometimes|string|min:8\',
            \'role\' => \'sometimes|in:buyer,seller,admin\',
        ]);

        $user->update($validated);

        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
');

file_put_contents('app/Http/Controllers/SellerProfileController.php', '<?php

namespace App\Http\Controllers;

use App\Models\SellerProfile;
use Illuminate\Http\Request;

class SellerProfileController extends Controller
{
    public function index()
    {
        return SellerProfile::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            \'user_id\' => \'required|exists:users,id\',
            \'store_name\' => \'required|string|max:255\',
            \'store_slug\' => \'required|string|max:255|unique:seller_profiles,store_slug\',
        ]);

        return SellerProfile::create($validated);
    }

    public function show(SellerProfile $sellerProfile)
    {
        return $sellerProfile;
    }

    public function update(Request $request, SellerProfile $sellerProfile)
    {
        $validated = $request->validate([
            \'user_id\' => \'sometimes|exists:users,id\',
            \'store_name\' => \'sometimes|string|max:255\',
            \'store_slug\' => \'sometimes|string|max:255|unique:seller_profiles,store_slug,\' . $sellerProfile->id,
        ]);

        $sellerProfile->update($validated);

        return $sellerProfile;
    }

    public function destroy(SellerProfile $sellerProfile)
    {
        $sellerProfile->delete();

        return response()->noContent();
    }
}
');

file_put_contents('app/Http/Controllers/ProductController.php', '<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            \'seller_id\' => \'required|exists:seller_profiles,id\',
            \'category_id\' => \'required|exists:categories,id\',
            \'name\' => \'required|string|max:255\',
            \'slug\' => \'required|string|max:255|unique:products,slug\',
            \'price\' => \'required|numeric\',
        ]);

        return Product::create($validated);
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            \'seller_id\' => \'sometimes|exists:seller_profiles,id\',
            \'category_id\' => \'sometimes|exists:categories,id\',
            \'name\' => \'sometimes|string|max:255\',
            \'slug\' => \'sometimes|string|max:255|unique:products,slug,\' . $product->id,
            \'price\' => \'sometimes|numeric\',
        ]);

        $product->update($validated);

        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
}
');

// Add more controllers for other models as needed (e.g., Category, Conversation, etc.)

// Routes
file_put_contents('routes/api.php', '<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SellerProfileController;
use App\Http\Controllers\ProductController;

Route::apiResource(\'users\', UserController::class);
Route::apiResource(\'seller-profiles\', SellerProfileController::class);
Route::apiResource(\'products\', ProductController::class);
// Add more resources as needed (e.g., categories, conversations, etc.)
');

echo "Files zilizoundwa kwa mafanikio kwenye folders: migrations, models, controllers, na routes/api.php. Run \'php artisan migrate\' sasa.\n";

?>
