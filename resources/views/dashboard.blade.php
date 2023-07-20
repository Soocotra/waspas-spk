<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div> --}}

    <!--Main-->
    <div class="container w-full pt-6 md:pt-8 px-6 mx-auto flex flex-wrap flex-col md:flex-row items-center">

        <!--Right Col-->
        <div class="xl:w-3/5 overflow-y-hidden">
            <img class="mx-auto lg:mr-0 slide-in-bottom" src="/images/dashboard.png">
        </div>

        <!--Left Col-->
        <div class="flex flex-col w-full xl:w-2/5 justify-center xl:items-start overflow-y-hidden items-center">
            @if ($projects->isNotEmpty())
                <h1
                    class="my-4 text-3xl md:text-4xl font-bold leading-tight text-center md:text-left slide-in-bottom-h1">
                    <span class="text-emerald-600">Proyek</span> yang baru dibuat:
                </h1>
                @php
                    $rank = 1;
                @endphp
                <div
                    class="overflow-x-auto flex-grow flex w-96 rounded-xl overflow-y-hidden space-x-3 scroll-smooth mb-5">
                    @foreach ($projects as $project)
                        <a href="{{ route('case-detail', $project) }}">
                            <x-card class=" flex  font-bold items-center w-96 shrink cursor-pointer"
                                padding="px-7 pr-20 py-5 md:pr-20 md:px-7" title="{{ $project->created_at }}"
                                color="bg-slate-800/90 text-secondary-300">
                                <h1 class="text-xl text-secondary-300 grow">
                                    {{ $project->name }}
                                </h1>
                                <div class="text-md text-secondary-300 ">
                                    @foreach (App\Models\Alternative::rankByProject($project->id)->limit(3)->get() as $alt)
                                        <h2>
                                            #{{ $rank }} {{ $alt->name }}
                                        </h2>
                                        @php
                                            $rank++;
                                        @endphp
                                    @endforeach
                                </div>
                            </x-card>
                        </a>
                    @endforeach
                </div>
            @else
                <h1
                    class="my-4 text-3xl md:text-4xl font-bold leading-tight text-center md:text-left slide-in-bottom-h1">
                    Kamu belum memiliki <span class="text-emerald-600">proyek</span>. </h1>
            @endif
            <p class="leading-normal text-base md:text-xl mb-8 text-center xl:text-left slide-in-bottom-subtitle">
                Selamat datang, {{ Auth::user()->name }}!
                Buat proyek sistem pendukung keputusan yang dapat mempermudah pemilihan solusi ideal atas masalah Anda
                kapan pun.</p>
            <div class="flex w-full justify-center xl:justify-start pb-24 lg:pb-0 fade-in">
                <a href="{{ route('history') }}">
                    <x-button xl right-icon="arrow-right" positive label="Tambah Kasus"
                        class="h-12 pr-4 bounce-top-icons" />
                </a>
                {{-- <img src="Play Store.svg" class="h-12 bounce-top-icons"> --}}
            </div>



        </div>

        <!--Footer-->
        <div class="w-full pt-16 pb-6 text-sm text-center md:text-left fade-in">
            <a class="text-gray-500 no-underline hover:no-underline" href="#">&copy; WASPAS App</a>
        </div>
    </div>
</x-app-layout>
