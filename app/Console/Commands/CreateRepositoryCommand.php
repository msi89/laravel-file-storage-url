<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name} {--m|model= : Create injected model for repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create model repository';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $repo_dir = join('/',  array(app_path(), 'Repositories'));

        if(!is_dir($repo_dir)){
            mkdir($repo_dir);
        }
        $repo = join('/', array($repo_dir, $this->argument('name').".php"));
        try {
            if(file_exists($repo)){
                return $this->error(sprintf('%s already exists', $this->argument('name')));
            }
           $this->writeContent($repo);

        } catch (\Exception $ex) {
            $this->error(sprintf('Failed to create repository'. PHP_EOL . $ex->getMessage()));
        }
        //$f = fopen($repo, 'w');
        return 0;
    }

    protected function writeContent(string $path){
       
        $model = $this->option('model');
        $f = fopen($path, 'w') or die("Unable to open file!");
        $content = "<?php ".PHP_EOL;
        $content .= "namespace App\Repositories;".PHP_EOL;
        $content .= "".PHP_EOL;
        $content .= $model ? "use App\\Models\\".$model.";".PHP_EOL : "".PHP_EOL;
        $content .= "".PHP_EOL;
        $content .= "class ". $this->argument('name'). "" .PHP_EOL; // class declaration
        $content .= "{".PHP_EOL; // start class
        $content .= "\t".$this->setModelAttr("protected ", ";")."".PHP_EOL; // model attribute
        $content .= "".PHP_EOL;
        $content .= "\t"."public function __construct(". $this->setModelAttr() .")".PHP_EOL; // constructor declaration
        $content .= "\t{".PHP_EOL; // start constructor
        $content .= "\t\t".$this->initializeModel()."".PHP_EOL; // initialize model in constructor
        $content .= "\t}".PHP_EOL; // end constructor
        $content .= "".PHP_EOL;
        $content .= "}".PHP_EOL; // and class

        fwrite($f, $content);
        fclose($f);
        $this->info(sprintf('Successfully created %s ', $this->argument('name')));
    }

    protected function setModelAttr(string $acc="", $end=""){
        return $this->option('model') ? $acc."".$this->option('model'). " $".strtolower($this->option('model'))."".$end : "";
    }
    
    protected function initializeModel(){
        return $this->option('model') ? '$this->'.strtolower($this->option('model')). " = $".strtolower($this->option('model')).";" : "";
    }
}