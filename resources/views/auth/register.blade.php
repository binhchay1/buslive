<x-guest-layout>
    <script src="{{ URL::to('/js/pages/register.js') }}" defer></script>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="{{ URL::to('img/logo-removebg.png') }}" width="500" height="300">
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Tên') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Mật khẩu') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Xác nhận mật khẩu') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="phone" value="{{ __('Số điện thoại') }}" />
                <x-jet-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autocomplete="phone" />
            </div>

            <div class="mt-4">
                <x-jet-label for="cmt" value="{{ __('CMT/CCCD') }}" />
                <x-jet-input id="cmt" class="block mt-1 w-full" type="text" name="cmt" :value="old('cmt')" required autocomplete="cmt" />
            </div>

            <div class="mt-4">
                <x-jet-label for="gender" value="{{ __('Giới tính') }}" />
                <select class="block mt-1 w-full" style="border-radius: 5px; border-color: #e0e3e8" name="gender" id="gender">
                    <option value="1">Nam</option>
                    <option value="2">Nữ</option>
                </select>
            </div>

            <div class="mb-3 mt-3">
                <label for="ticket-to" class="form-label">Ngày sinh</label>
                <div class="row mt-1">
                    <select class="col-sm-4" id="year" name="year" onchange="change_year(this)" style="border-radius: 5px; border-color: #e0e3e8">
                    </select>
                    <select class="col-sm-4" id="month" name="month" onchange="change_month(this)" style="border-radius: 5px; border-color: #e0e3e8">
                    </select>
                    <select class="col-sm-4" id="day" name="day" style="border-radius: 5px; border-color: #e0e3e8">
                    </select>
                </div>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="mt-4">
                <x-jet-label for="terms">
                    <div class="flex items-center">
                        <x-jet-checkbox name="terms" id="terms" />

                        <div class="ml-2">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </div>
                    </div>
                </x-jet-label>
            </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Bạn đã đăng ký?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Đăng ký') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>