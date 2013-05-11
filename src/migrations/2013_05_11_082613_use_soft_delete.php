<?php

use Illuminate\Database\Migrations\Migration;

class UseSoftDelete extends Migration {

    public function __construct()
    {
        // Get the prefix
        $this->prefix = Config::get('verify::prefix', '');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Bring to local scope
        $prefix = $this->prefix;

        // Add soft delete column
        Schema::table($prefix.'users', function($table)
        {
            $table->dateTime('deleted_at')->nullable()->index();
        });

        $users = DB::table($prefix.'users')
            ->where('deleted', 1)
            ->update(array(
                'deleted_at' => date('Y-m-d H:i:s')
            ));

        Schema::table($prefix.'users', function($table)
        {
            $table->dropColumn('deleted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Bring to local scope
        $prefix = $this->prefix;

        // Add soft delete column
        Schema::table($prefix.'users', function($table)
        {
            $table->boolean('deleted')->default(0);
        });

        $users = DB::table($prefix.'users')
            ->whereNotNull('deleted_at')
            ->update(array(
                'deleted' => 1
            ));

        Schema::table($prefix.'users', function($table)
        {
            $table->dropColumn('deleted_at');
        });
    }

}