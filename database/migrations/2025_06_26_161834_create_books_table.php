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
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            // Informasi Bibliografi
            $table->string('title');
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->string('isbn')->nullable()->unique();
            $table->unsignedSmallInteger('published_year')->nullable();
            $table->string('edition')->nullable();
            $table->string('language')->default('Indonesia');
            $table->unsignedInteger('page_count')->nullable();
            $table->text('synopsis')->nullable();

            // Cover & Kategori
            $table->string('cover_url')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Status eBook
            $table->boolean('is_readable')->default(false);

            // Popularitas (dari Internet Archive atau internal tracking)
            $table->unsignedBigInteger('view_count')->default(0);

            // Rating opsional
            $table->float('rating', 2, 1)->nullable();
            $table->unsignedInteger('rating_count')->default(0);

            $table->string('google_id')->nullable()->unique();
            $table->string('read_url')->nullable();
            $table->string('source')->default('manual');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
