<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('top') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="TopMessage text-center"> TOPページです<br>今日やること</div>
                </div>
                <?php
                $a = 'テストメッセージです';
                echo $a;
                ?>


                <div class="row">
                    <div class="col-sm-12 col-md-3">aaa</div>
                    <div class="col-sm-12 col-md-3">aaa</div>
                    <div class="col-sm-12 col-md-3">aaa</div>
                    <div class="col-sm-12 col-md-3">aaa</div>
                    <div class="col-sm-12 col-md-3">aaa</div>
                    <div class="col-sm-12 col-md-3">aaa</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>