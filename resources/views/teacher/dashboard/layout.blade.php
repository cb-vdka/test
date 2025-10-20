<!DOCTYPE html>
<html lang="en">

<head>
    @include('teacher.dashboard.components.head')
    @livewireStyles
</head>

<body>
    <div class="wrapper">
        @include('teacher.dashboard.components.sidebar')

        <div class="main-panel">
            @include('teacher.dashboard.components.navbar')

            <div class="container">
                @include($template)
            </div>

            @include('teacher.dashboard.components.footer')

        </div>

    </div>

    @include('teacher.dashboard.components.script')
    @livewireScripts
</body>

</html>
