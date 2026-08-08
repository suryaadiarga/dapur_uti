<?php

namespace Tests\Feature;

use App\Models\ExpenseTransaction;
use App\Models\IncomeTransaction;
use App\Models\Inventory;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FinanceApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_pages_are_protected_by_authentication(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/income')->assertRedirect('/login');
        $this->get('/expense')->assertRedirect('/login');
        $this->get('/reports')->assertRedirect('/login');
    }

    public function test_admin_can_create_core_finance_records_and_see_dashboard(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $person = Person::create(['name' => 'Uti', 'role' => 'pemilik']);

        $this->actingAs($user)->post(route('income.store'), [
            'transaction_date' => now()->toDateString(),
            'people_id' => $person->id,
            'category' => 'modal_pemilik',
            'amount' => 1000000,
            'payment_method' => 'transfer',
            'description' => 'Modal awal',
            'proof' => UploadedFile::fake()->image('bukti.jpg'),
        ])->assertRedirect(route('income.index'));

        $this->actingAs($user)->post(route('expense.store'), [
            'transaction_date' => now()->toDateString(),
            'people_id' => $person->id,
            'category' => 'belanja_bahan',
            'amount' => 250000,
            'payment_method' => 'tunai',
            'store_name' => 'Pasar',
            'description' => 'Belanja harian',
            'receipt' => UploadedFile::fake()->image('nota.jpg'),
        ])->assertRedirect(route('expense.index'));

        $this->actingAs($user)->post(route('inventories.store'), [
            'name' => 'Kompor',
            'category' => 'alat_masak',
            'purchase_date' => now()->toDateString(),
            'purchase_price' => 500000,
            'quantity' => 2,
            'condition' => 'baik',
            'location' => 'Dapur',
            'people_id' => $person->id,
        ])->assertRedirect(route('inventories.index'));

        $this->assertDatabaseCount('income_transactions', 1);
        $this->assertDatabaseCount('expense_transactions', 1);
        $this->assertDatabaseCount('inventories', 1);
        $this->assertSame(750000.0, (float) IncomeTransaction::sum('amount') - (float) ExpenseTransaction::sum('amount'));
        $this->assertSame(1000000.0, Inventory::first()->total_value);

        $this->actingAs($user)->get('/dashboard')
            ->assertOk()
            ->assertSee('Rp 750.000')
            ->assertSee('Rp 1.000.000');
    }

    public function test_reports_and_cash_book_can_be_viewed(): void
    {
        $user = User::factory()->create();
        $person = Person::create(['name' => 'Uti', 'role' => 'pemilik']);
        IncomeTransaction::create([
            'transaction_date' => now(),
            'people_id' => $person->id,
            'category' => 'tambahan_kas',
            'amount' => 100000,
            'payment_method' => 'tunai',
            'created_by' => $user->id,
        ]);

        $this->actingAs($user)->get('/cash')->assertOk()->assertSee('Rp 100.000');
        $this->actingAs($user)->get('/reports?type=income&period=month')->assertOk()->assertSee('Laporan Uang Masuk');
        $this->actingAs($user)->get('/reports/pdf?type=income&period=month')->assertOk()->assertHeader('content-type', 'application/pdf');
        $this->actingAs($user)->get('/reports/excel?type=income&period=month')->assertOk();
    }

    public function test_all_main_pages_render_for_authenticated_admin(): void
    {
        $user = User::factory()->create();
        Person::create(['name' => 'Uti', 'role' => 'pemilik']);

        foreach ([
            '/dashboard', '/people', '/people/create', '/income', '/income/create',
            '/expense', '/expense/create', '/receipts', '/inventories',
            '/inventories/create', '/cash', '/reports', '/settings',
        ] as $url) {
            $this->actingAs($user)->get($url)->assertOk();
        }
    }
}
