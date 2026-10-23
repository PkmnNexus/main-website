<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

new class extends Component
{
    use WithFileUploads;

    public string $name = '';

    public ?string $surname = null;

    public string $display_name = '';

    public string $email = '';

    public ?string $bio = null;

    public ?string $website = null;

    public ?string $social_link_1 = null;

    public ?string $social_link_2 = null;

    public ?string $social_link_3 = null;

    public ?string $social_link_4 = null;

    public string $password = '';

    public string $password_confirmation = '';

    #[Validate('nullable|image|max:2048')]
    public $avatar = null;

    public function mount(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $this->name = $user->name;
        $this->surname = $user->surname;
        $this->display_name = $user->display_name;
        $this->email = $user->email;
        $this->bio = $user->bio;
        $this->website = $user->website;
        $this->social_link_1 = $user->social_link_1;
        $this->social_link_2 = $user->social_link_2;
        $this->social_link_3 = $user->social_link_3;
        $this->social_link_4 = $user->social_link_4;
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['nullable', 'string', 'max:255'],
            'display_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'display_name')->ignore(Auth::id()),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(Auth::id()),
            ],
            'bio' => ['nullable', 'string', 'max:1000'],
            'website' => ['nullable', 'url', 'max:255'],
            'social_link_1' => ['nullable', 'url', 'max:255'],
            'social_link_2' => ['nullable', 'url', 'max:255'],
            'social_link_3' => ['nullable', 'url', 'max:255'],
            'social_link_4' => ['nullable', 'url', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function save(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $this->validate();

        $user->name = $validated['name'];
        $user->surname = $validated['surname'];
        $user->display_name = $validated['display_name'];
        $user->email = $validated['email'];
        $user->bio = $validated['bio'];
        $user->website = $validated['website'];
        $user->social_link_1 = $validated['social_link_1'];
        $user->social_link_2 = $validated['social_link_2'];
        $user->social_link_3 = $validated['social_link_3'];
        $user->social_link_4 = $validated['social_link_4'];

        if (filled($validated['password'])) {
            $user->password = $validated['password'];
        }

        if ($this->avatar) {
            $user->addMedia($this->avatar->getRealPath())
                ->usingFileName($this->avatar->getClientOriginalName())
                ->toMediaCollection('user_avatar');
        }

        auth()->user()->forceFill([
            'last_activity_at' => now(),
        ])->save();

        $user->save();

        $this->reset('password', 'password_confirmation', 'avatar');

        session()->flash('status', 'Profile updated successfully.');
    }
};
?>

<div class="max-w-3xl">

    <form wire:submit="save" class="space-y-8">

        <section class="space-y-6">

            <div>

                <h2 class="font-display font-bold text-xl text-[var(--color-secondary)]">Personal information</h2>

                <p class="mt-1 text-sm text-gray-600">Update your profile information.</p>

            </div>

            @if (session('status'))

                <div role="status" class="rounded-sm bg-green-50 border border-green-200 p-4 text-sm text-green-800">{{ session('status') }}</div>

            @endif

            <div>

                <label for="name" class="block text-sm font-bold mb-2">Name</label>

                <input id="name"
                       type="text"
                       wire:model="name"
                       autocomplete="given-name"
                       required
                       class="w-full rounded-sm border border-gray-300 px-4 py-3">

                @error('name')

                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                @enderror

            </div>

            <div>

                <label for="surname" class="block text-sm font-bold mb-2">Surname</label>

                <input id="surname"
                       type="text"
                       wire:model="surname"
                       autocomplete="family-name"
                       class="w-full rounded-sm border border-gray-300 px-4 py-3">

                @error('surname')

                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                @enderror

            </div>

            <div>

                <label for="display_name" class="block text-sm font-bold mb-2">Display name</label>

                <input id="display_name"
                       type="text"
                       wire:model="display_name"
                       autocomplete="nickname"
                       required
                       class="w-full rounded-sm border border-gray-300 px-4 py-3">

                @error('display_name')

                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                @enderror

            </div>

            <div>

                <label for="email" class="block text-sm font-bold mb-2">Email address</label>

                <input id="email"
                       type="email"
                       wire:model="email"
                       autocomplete="email"
                       required
                       class="w-full rounded-sm border border-gray-300 px-4 py-3">

                @error('email')

                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                @enderror

            </div>

            <div>

                <label for="bio" class="block text-sm font-bold mb-2">Bio</label>

                <textarea id="bio"
                          wire:model="bio"
                          rows="4"
                          maxlength="1000"
                          class="w-full rounded-sm border border-gray-300 px-4 py-3"></textarea>

                <p class="mt-1 text-sm text-gray-500">Maximum 1000 characters.</p>

                @error('bio')

                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                @enderror

            </div>

        </section>

        <section class="space-y-6">

            <div>

                <h2 class="font-display font-bold text-xl text-[var(--color-secondary)]">Social</h2>

                <p class="mt-1 text-sm text-gray-600">Add your website and social profile links. All fields are optional.</p>

            </div>

            <div>

                <label for="website" class="block text-sm font-bold mb-2">Website</label>

                <input id="website"
                       type="url"
                       wire:model="website"
                       placeholder="https://example.com"
                       autocomplete="url"
                       class="w-full rounded-sm border border-gray-300 px-4 py-3">

                @error('website')

                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                @enderror

            </div>

            <div>

                <label for="social_link_1" class="block text-sm font-bold mb-2">Social link 1</label>

                <input id="social_link_1"
                       type="url"
                       wire:model="social_link_1"
                       placeholder="https://"
                       class="w-full rounded-sm border border-gray-300 px-4 py-3">

                @error('social_link_1')

                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                @enderror

            </div>

            <div>

                <label for="social_link_2" class="block text-sm font-bold mb-2">Social link 2</label>

                <input id="social_link_2"
                       type="url"
                       wire:model="social_link_2"
                       placeholder="https://"
                       class="w-full rounded-sm border border-gray-300 px-4 py-3">

                @error('social_link_2')

                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                @enderror

            </div>

            <div>

                <label for="social_link_3" class="block text-sm font-bold mb-2">Social link 3</label>

                <input id="social_link_3"
                       type="url"
                       wire:model="social_link_3"
                       placeholder="https://"
                       class="w-full rounded-sm border border-gray-300 px-4 py-3">

                @error('social_link_3')

                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                @enderror

            </div>

            <div>

                <label for="social_link_4" class="block text-sm font-bold mb-2">Social link 4</label>

                <input id="social_link_4"
                       type="url"
                       wire:model="social_link_4"
                       placeholder="https://"
                       class="w-full rounded-sm border border-gray-300 px-4 py-3">

                @error('social_link_4')

                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                @enderror

            </div>

        </section>

        <section class="rounded-lg border border-gray-200 bg-white p-6 space-y-6">

            <div>

                <h2 class="font-display font-bold text-xl text-[var(--color-secondary)]">Profile picture</h2>

                <p class="mt-1 text-sm text-gray-600">Upload a new profile picture. Maximum file size: 2 MB.</p>

            </div>

            <div class="flex flex-col sm:flex-row sm:items-center gap-6">

                <div class="w-[150px] h-[150px] shrink-0 rounded-sm border border-gray-200 p-1">

                    @if ($avatar)

                        <img src="{{ $avatar->temporaryUrl() }}"
                             alt="Profile picture preview"
                             class="w-full h-full object-cover rounded-sm">

                    @else

                        <img src="{{ Auth::user()->getFirstMediaUrl('user_avatar') ?: asset('images/default_avatar.png') }}"
                             alt="{{ Auth::user()->display_name }}'s profile picture"
                             class="w-full h-full object-cover rounded-sm">

                    @endif

                </div>

                <div class="flex-1 min-w-0">

                    <input id="avatar"
                           type="file"
                           wire:model="avatar"
                           accept="image/*"
                           aria-label="Choose a profile picture"
                           class="block w-full min-w-0 text-sm text-gray-600 file:mr-4 file:rounded-sm file:border-0 file:bg-gradient file:px-4 file:py-2 file:font-display file:font-bold file:text-white">

                    @error('avatar')

                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                    @enderror

                    <div wire:loading wire:target="avatar" class="mt-2 text-sm text-gray-500">
                        Uploading image...
                    </div>

                </div>

            </div>

        </section>

        <section class="space-y-6 border-t border-gray-200 pt-8">

            <div>

                <h2 class="font-display font-bold text-xl text-[var(--color-secondary)]">Change password</h2>

                <p class="mt-1 text-sm text-gray-600">Leave both password fields empty if you do not want to change your password.</p>

            </div>

            <div>

                <label for="password" class="block text-sm font-bold mb-2">New password</label>

                <input id="password"
                       type="password"
                       wire:model="password"
                       autocomplete="new-password"
                       class="w-full rounded-sm border border-gray-300 px-4 py-3">

                @error('password')

                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                @enderror

            </div>

            <div>

                <label for="password_confirmation" class="block text-sm font-bold mb-2">Confirm new password</label>

                <input id="password_confirmation"
                       type="password"
                       wire:model="password_confirmation"
                       autocomplete="new-password"
                       class="w-full rounded-sm border border-gray-300 px-4 py-3">

            </div>

        </section>

        <div class="border-t border-gray-200 pt-6">

            <button type="submit"
                    wire:loading.attr="disabled"
                    wire:target="save, avatar"
                    class="rounded-sm bg-gradient px-6 py-3 font-display font-bold text-white transition-opacity duration-200 disabled:opacity-50">

                <span wire:loading.remove wire:target="save">Save changes</span>
                <span wire:loading wire:target="save">Saving...</span>

            </button>

        </div>

    </form>

</div>