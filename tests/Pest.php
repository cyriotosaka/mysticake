<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| Bind all Feature tests to the Laravel TestCase and enable RefreshDatabase
| so every test runs inside an isolated, auto-rolled-back DB transaction.
|
*/

pest()->extend(Tests\TestCase::class)
    ->in('Unit');

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');
