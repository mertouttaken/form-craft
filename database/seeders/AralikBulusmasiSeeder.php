<?php

namespace Database\Seeders;

use App\Models\Answers;
use App\Models\Fields;
use App\Models\Forms;
use App\Models\Submissions;
use App\Models\Workspaces;
use Carbon\CarbonImmutable;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AralikBulusmasiSeeder extends Seeder
{
    /**
     * The published sample form used across the preview pages:
     * six fields and 128 submissions. The newest eight match the
     * rows on the submissions page.
     */
    public function run(): void
    {
        $workspace = Workspaces::where('slug', 'deniz')->firstOrFail();

        $form = Forms::create([
            'workspace_id' => $workspace->id,
            'title' => 'Aralık Buluşmasına kayıt',
            'description' => "Aralık Buluşması için kayıt formu. 10 Aralık'a kadar açık.",
            'public_slug' => 'aralik-bulusmasi',
            'status' => 'published',
            'settings' => json_encode([
                'success_message' => 'Kaydın alındı.',
                'redirect_url' => null,
                'notify_email' => 'deniz@ornek.com',
                'allow_multiple' => false,
            ], JSON_UNESCAPED_UNICODE),
            'submissions_count' => 128,
        ]);

        $definitions = [
            'name' => ['text', 'Ad soyad', 'Deniz Yılmaz', 'Yaka kartında bu isim yazacak.', true, null, null],
            'email' => ['email', 'E-posta', 'ornek@eposta.com', 'Onay ve hatırlatma için.', true, null, null],
            'session' => ['radio', 'Hangi oturuma katılacaksın?', null, 'Birini seç.', true, ['Sabah', 'Öğleden sonra', 'İkisi de'], null],
            'attendees' => ['number', 'Kaç kişi geleceksin?', null, '1 ile 4 arası.', false, null, ['min' => 1, 'max' => 4]],
            'arrival' => ['date', 'Geliş tarihi', null, null, false, null, null],
            'note' => ['textarea', 'Notun var mı?', null, 'İsteğe bağlı.', false, null, ['max' => 1000]],
        ];

        $fields = [];
        $position = 1;
        foreach ($definitions as $key => [$type, $label, $placeholder, $help, $required, $options, $rules]) {
            $fields[$key] = Fields::create([
                'form_id' => $form->id,
                'type' => $type,
                'label' => $label,
                'placeholder' => $placeholder,
                'help_text' => $help,
                'is_required' => $required,
                'options' => $options ? json_encode($options, JSON_UNESCAPED_UNICODE) : null,
                'rules' => $rules ? json_encode($rules) : null,
                'position' => $position++,
            ])->id;
        }

        foreach ($this->responses() as $response) {
            $submission = Submissions::create([
                'form_id' => $form->id,
                'submitted_at' => $response['submitted_at'],
                'ip_hash' => hash('sha256', $response['email']),
                'user_agent' => 'Mozilla/5.0 (örnek veri)',
            ]);

            $rows = [];
            foreach ($fields as $key => $fieldId) {
                if ($response[$key] === null) {
                    continue;
                }

                $rows[] = [
                    'submission_id' => $submission->id,
                    'field_id' => $fieldId,
                    'value' => (string) $response[$key],
                    'created_at' => $response['submitted_at'],
                    'updated_at' => $response['submitted_at'],
                ];
            }
            Answers::insert($rows);
        }
    }

    /**
     * 120 generated responses, then the eight shown on the submissions page.
     *
     * @return list<array{submitted_at: CarbonImmutable, name: string, email: string, session: string, attendees: ?int, arrival: ?string, note: ?string}>
     */
    private function responses(): array
    {
        $faker = Faker::create('tr_TR');
        $faker->seed(2026);

        $responses = [];
        $time = CarbonImmutable::parse('2026-10-01 09:00', 'Europe/Istanbul');
        for ($i = 0; $i < 120; $i++) {
            $time = $time->addMinutes($faker->numberBetween(60, 800));
            $responses[] = [
                'submitted_at' => $time,
                'name' => $faker->firstName().' '.$faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'session' => $faker->randomElement(['Sabah', 'Öğleden sonra', 'İkisi de']),
                'attendees' => $faker->optional(0.8)->numberBetween(1, 4),
                'arrival' => $faker->optional(0.7)->randomElement(['2026-12-10', '2026-12-11', '2026-12-12']),
                'note' => $faker->optional(0.2)->randomElement([
                    'Vejetaryen menü olursa sevinirim.',
                    'Biraz geç katılabilirim.',
                    'Engelli erişimi var mı?',
                    'Otopark bilgisi paylaşır mısınız?',
                ]),
            ];
        }

        $newest = [
            ['2026-11-26 08:12', 'Elif Şahin', 'elif@ornek.com', 'Sabah', 1, null, null],
            ['2026-11-26 20:55', 'Kaan Öztürk', 'kaan@ornek.com', 'Sabah', 2, '2026-12-12', null],
            ['2026-11-27 14:03', 'Deniz Yılmaz', 'deniz@ornek.com', 'İkisi de', 4, '2026-12-10', null],
            ['2026-11-27 16:28', 'Ece Kaya', 'ece@ornek.com', 'Öğleden sonra', 1, '2026-12-10', null],
            ['2026-11-28 09:40', 'Mert Aydın', 'mert@ornek.com', 'Sabah', null, '2026-12-11', null],
            ['2026-11-28 22:15', 'Zeynep Çelik', 'zeynep@ornek.com', 'Öğleden sonra', 3, null, null],
            ['2026-11-29 11:02', 'Burak Demir', 'burak@ornek.com', 'Sabah', 1, '2026-12-10', null],
            ['2026-11-29 18:41', 'Selin Arslan', 'selin@ornek.com', 'İkisi de', 2, '2026-12-10', 'Vejetaryen menü olursa sevinirim.'],
        ];

        foreach ($newest as [$at, $name, $email, $session, $attendees, $arrival, $note]) {
            $responses[] = [
                'submitted_at' => CarbonImmutable::parse($at, 'Europe/Istanbul'),
                'name' => $name,
                'email' => $email,
                'session' => $session,
                'attendees' => $attendees,
                'arrival' => $arrival,
                'note' => $note,
            ];
        }

        return $responses;
    }
}
