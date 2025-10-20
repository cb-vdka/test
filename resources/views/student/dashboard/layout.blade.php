<!DOCTYPE html>
<html lang="en">

<head>
    @include('student.dashboard.components.head')
    @livewireStyles
</head>

<body>
    <div class="wrapper">
        @include('student.dashboard.components.sidebar')


        <div class="main-panel">
            @include('student.dashboard.components.navbar')

            <div class="container">
                @include($template)
            </div>

            @include('student.dashboard.components.footer')

        </div>

        @include('student.dashboard.components.custom')

    </div>


    @include('student.dashboard.components.script')
    @livewireScripts
</body>

</html>
