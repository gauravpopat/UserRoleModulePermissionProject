<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class getQuote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:quote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get quote related to programming';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $quote = array(
            "1"     =>  "Any fool can write code that a computer can understand. Good programmers write code that humans can understand.",
            "2"     =>  "First, solve the problem. Then, write the code.",
            "3"     =>  "In order to be irreplaceable, one must always be different",
            "4"     =>  "Java is to JavaScript what car is to Carpet.",
            "5"     =>  "Knowledge is power.",
            "6"     =>  "Sometimes it pays to stay in bed on Monday, rather than spending the rest of the week debugging Monday's code.",
            "7"     =>  "Perfection is achieved not when there is nothing more to add, but rather when there is nothing more to take away.",
            "8"     =>  "Ruby is rubbish! PHP is phpantastic!",
            "9"     =>  "Code is like humor. When you have to explain it, it's bad.",
            "10"    =>  "Fix the cause, not the symptom.",
            "11"    =>  "Optimism is an occupational hazard of programming: feedback is the treatment.",
            "12"    =>  "When to use iterative development? You should use iterative development only on projects that you want to succeed.",
            "13"    =>  "Before software can be reusable it first has to be usable.",
            "14"    =>  "Simplicity is the soul of efficiency.",
            "15"    =>  "Make it work, make it right, make it fast.",
            '16'    =>  "The most important property of a program is whether it accomplishes the intention of its user.",
        );

        shuffle($quote);
        return $this->info($quote[0]);
    }
}
