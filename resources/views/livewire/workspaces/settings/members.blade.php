<main class="wrap">
  <div class="pagehead"><div><h1 class="d-lg">Üyeler</h1><p class="lede">Kim neyi görebilir, kim neyi değiştirebilir.</p></div></div>
  @if ($notice)
    <p class="notice" role="status" wire:key="notice-{{ md5($notice.microtime()) }}" style="margin-bottom:1.5rem"><b>{{ $notice }}</b></p>
  @endif
  <div class="layout">
    <section class="paper roster" data-fc-in aria-labelledby="rh">
      <div class="head"><h2 id="rh" class="lbl">Ekip · {{ $members->count() }} kişi</h2><span class="lbl muted">Sahip · Editör · İzleyici</span></div>
      @foreach ($members as $member)
        <div class="person" wire:key="member-{{ $member->id }}"><span class="av">{{ $member->initials() }}</span><div><b>{{ $member->name }}</b><small>{{ $member->email }}@if (auth()->id() === $member->id) · sen @endif</small></div>
          @if ($member->pivot->role === 'owner')
            <span class="owner">Sahip</span><span></span>
          @else
            <form wire:submit="removeMember({{ $member->id }})" wire:confirm="{{ $member->name }} ekipten çıkarılsın mı?" style="display:contents">
              <select class="role" aria-label="{{ $member->name }} rolü" wire:change="updateRole({{ $member->id }}, $event.target.value)">
                @foreach (\App\Livewire\Workspaces\Settings\Members::ROLES as $value => $label)
                  <option value="{{ $value }}" @selected($member->pivot->role === $value)>{{ $label }}</option>
                @endforeach
              </select>
              <button class="btn btn--sm btn--ghost" type="submit" style="color:var(--stamp)">Çıkar</button>
            </form>
          @endif
        </div>
      @endforeach
    </section>

    <aside>
      <div class="env" data-fc-in>
        <h2 class="d-md" style="font-size:1.6rem;position:relative">Davet gönder</h2>
        <form wire:submit="invite" novalidate>
          <div @class(['field', 'field--error' => $errors->has('inviteEmail')])><label class="lbl" for="ie">E-posta</label><input class="input" id="ie" type="email" wire:model="inviteEmail" placeholder="ad@ornek.com" required>
            @error('inviteEmail')<p class="field__error">{{ $message }}</p>@enderror</div>
          <div class="field"><label class="lbl" for="ir">Rol</label><select class="select input" id="ir" wire:model="inviteRole">
            @foreach (\App\Livewire\Workspaces\Settings\Members::ROLES as $value => $label)
              <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
          </select></div>
          <button class="btn btn--stamp" type="submit" wire:loading.attr="disabled" wire:target="invite">Daveti gönder</button>
          <p class="field__help">Davet linki 7 gün geçerli ve tek kullanımlık.</p>
        </form>
      </div>
      <div class="pending" data-fc-in>
        <h2>Bekleyen davetler · {{ $invitations->count() }}</h2>
        @forelse ($invitations as $invitation)
          @php($daysLeft = max(1, (int) ceil(now()->diffInHours(\Illuminate\Support\Carbon::parse($invitation->expires_at)) / 24)))
          <form class="inv" wire:key="invitation-{{ $invitation->id }}" wire:submit="revokeInvitation({{ $invitation->id }})" style="--r:{{ $loop->odd ? '-.6deg' : '.5deg' }}">
            <div><b>{{ $invitation->email }}</b><small>{{ \App\Livewire\Workspaces\Settings\Members::ROLES[$invitation->role] ?? $invitation->role }} · {{ $daysLeft }} gün kaldı</small></div>
            <button class="btn btn--sm btn--ghost" type="submit">Geri al</button>
          </form>
        @empty
          <p class="field__help">Bekleyen davet yok.</p>
        @endforelse
      </div>
      <p class="readonly">İzleyici rolündeki üyeler bu sayfayı yalnızca görüntüler; davet ve rol düğmeleri onlara kapalıdır.</p>
    </aside>
  </div>
</main>
