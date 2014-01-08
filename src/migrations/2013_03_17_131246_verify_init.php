<?php
use Illuminate\Database\Migrations\Migration;

class VerifyInit extends Migration {

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

        // Create the permissions table
        Schema::create($prefix.'permissions', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name', 100)->index();
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });

        // Create the roles table
        Schema::create($prefix.'roles', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name', 100)->index();
            $table->string('description', 255)->nullable();
            $table->integer('level');
            $table->timestamps();
        });

        // Create the users table
        Schema::create($prefix.'users', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('username', 30)->index();
            $table->string('password', 60)->index();
            $table->string('salt', 32);
            $table->string('email', 255)->index();
            $table->boolean('verified')->default(0);
            $table->boolean('disabled')->default(0);
            $table->boolean('deleted')->default(0);
            $table->timestamps();
        });

        // Create the role/user relationship table
        Schema::create($prefix.'role_user', function($table) use ($prefix)
        {
            $table->engine = 'InnoDB';

            $table->integer('user_id')->unsigned()->index();
            $table->integer('role_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on($prefix.'users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on($prefix.'roles')->onDelete('cascade');
        });

        // Create the permission/role relationship table
        Schema::create($prefix.'permission_role', function($table) use ($prefix)
        {
            $table->engine = 'InnoDB';

            $table->integer('permission_id')->unsigned()->index();
            $table->integer('role_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('permission_id')->references('id')->on($prefix.'permissions')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on($prefix.'roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->prefix.'role_user');
        Schema::drop($this->prefix.'permission_role');
        Schema::drop($this->prefix.'users');
        Schema::drop($this->prefix.'roles');
        Schema::drop($this->prefix.'permissions');
    }
}
