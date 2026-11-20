<?php

namespace Database\Seeders;

use App\Models\Answers;
use App\Models\Fields;
use App\Models\Forms;
use App\Models\Submissions;
use App\Models\Workspaces;
use Carbon\CarbonImmutable;
use Faker\Factory as Faker;
use Faker\Generator;
use Illuminate\Database\Seeder;

class SampleFormSeeder extends Seeder
{
    /**
     * The other forms on the forms page (a draft and a closed survey,
     * filling the free plan's three-form limit) and one form in the
     * pro workspace.
     */
    public function run(): void
    {
        $free = Workspaces::where('slug', 'deniz')->firstOrFail();
        $pro = Workspaces::where('slug', 'pro-ekibi')->firstOrFail();

        $this->seedForm($free->id, 'Stajyer başvurusu', 'stajyer-basvurusu', 'draft', 'Yaz dönemi stajyer başvuru formu.', [
            ['text', 'Ad soyad', true, null],
            ['email', 'E-posta', true, null],
            ['text', 'Okul', true, null],
            ['select', 'Bölüm', true, ['Bilgisayar Mühendisliği', 'Yazılım Mühendisliği', 'Endüstri Mühendisliği', 'Diğer']],
            ['number', 'Sınıf', true, null],
            ['checkbox', 'İlgi alanların', false, ['Backend', 'Frontend', 'Mobil', 'Veri']],
            ['date', 'Başlayabileceğin tarih', true, null],
            ['text', 'GitHub profilin', false, null],
            ['textarea', 'Neden bizimle çalışmak istiyorsun?', true, null],
        ]);

        $this->seedForm($free->id, 'Yaz okulu memnuniyet anketi', 'yaz-okulu-anketi', 'closed', 'Yaz okulu sonrası kısa memnuniyet anketi.', [
            ['text', 'Ad soyad', false, null],
            ['email', 'E-posta', false, null],
            ['radio', 'Genel memnuniyetin', true, ['Çok memnunum', 'Memnunum', 'Kararsızım', 'Memnun değilim']],
            ['select', 'En faydalı oturum', true, ['Laravel temelleri', 'Livewire', 'Test yazma', 'Veritabanı tasarımı']],
            ['number', 'Eğitmeni 1 ile 10 arası puanla', true, null],
            ['checkbox', 'Gelecek yıl ne görmek istersin?', false, ['Daha çok pratik', 'Proje günü', 'Mentorluk', 'Online seçenek']],
            ['textarea', 'Eklemek istediğin bir şey', false, null],
        ], 84, '2026-08-01 10:00');

        $this->seedForm($pro->id, 'Haftalık ekip anketi', 'haftalik-ekip-anketi', 'published', 'Her cuma kısa ekip nabzı.', [
            ['radio', 'Bu hafta nasıldı?', true, ['İyi', 'Orta', 'Zor']],
            ['textarea', 'Takıldığın bir şey var mı?', false, null],
            ['email', 'E-posta', false, null],
        ]);
    }

    /**
     * @param  list<array{0: string, 1: string, 2: bool, 3: ?list<string>}>  $definitions
     */
    private function seedForm(int $workspaceId, string $title, string $slug, string $status, string $description, array $definitions, int $submissionCount = 0, ?string $firstSubmission = null): void
    {
        $form = Forms::create([
            'workspace_id' => $workspaceId,
            'title' => $title,
            'description' => $description,
            'public_slug' => $slug,
            'status' => $status,
            'settings' => json_encode([
                'success_message' => 'Teşekkürler, yanıtın alındı.',
                'redirect_url' => null,
                'notify_email' => null,
                'allow_multiple' => false,
            ], JSON_UNESCAPED_UNICODE),
            'submissions_count' => $submissionCount,
        ]);

        $fields = [];
        foreach ($definitions as $index => [$type, $label, $required, $options]) {
            $fields[] = Fields::create([
                'form_id' => $form->id,
                'type' => $type,
                'label' => $label,
                'is_required' => $required,
                'options' => $options ? json_encode($options, JSON_UNESCAPED_UNICODE) : null,
                'rules' => $type === 'number' ? json_encode(['min' => 1, 'max' => 10]) : null,
                'position' => $index + 1,
            ]);
        }

        if ($submissionCount === 0) {
            return;
        }

        $faker = Faker::create('tr_TR');
        $faker->seed(crc32($slug));
        $time = CarbonImmutable::parse($firstSubmission, 'Europe/Istanbul');

        for ($i = 0; $i < $submissionCount; $i++) {
            $time = $time->addMinutes($faker->numberBetween(30, 600));
            $submission = Submissions::create([
                'form_id' => $form->id,
                'submitted_at' => $time,
                'ip_hash' => hash('sha256', $faker->ipv4()),
                'user_agent' => 'Mozilla/5.0 (örnek veri)',
            ]);

            $rows = [];
            foreach ($fields as $field) {
                $value = $this->fakeValue($faker, $field);
                if ($value === null) {
                    continue;
                }

                $rows[] = [
                    'submission_id' => $submission->id,
                    'field_id' => $field->id,
                    'value' => $value,
                    'created_at' => $time,
                    'updated_at' => $time,
                ];
            }
            Answers::insert($rows);
        }
    }

    /**
     * A plausible answer for one field, or null for a skipped optional field.
     */
    private function fakeValue(Generator $faker, Fields $field): ?string
    {
        if (! $field->is_required && $faker->boolean(25)) {
            return null;
        }

        $options = $field->options ? json_decode($field->options, true) : [];

        return match ($field->type) {
            'text' => $faker->firstName().' '.$faker->lastName(),
            'email' => $faker->safeEmail(),
            'number' => (string) $faker->numberBetween(1, 10),
            'date' => $faker->dateTimeBetween('2026-06-01', '2026-09-30')->format('Y-m-d'),
            'radio', 'select' => $faker->randomElement($options),
            'checkbox' => json_encode($faker->randomElements($options, $faker->numberBetween(1, 2)), JSON_UNESCAPED_UNICODE),
            default => $faker->sentence(),
        };
    }
}
