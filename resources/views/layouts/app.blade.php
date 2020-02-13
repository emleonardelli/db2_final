<!DOCTYPE html>
<html>

@include('layouts.elements.header')

<body>
    @include('layouts.elements.nav')
    
    <div class="container">
        <div class="columns">
            <div class="column is-2 ">
                @include('layouts.elements.aside')
            </div>
            <div class="column is-10">
                @yield('content')
            </div>
        </div>
    </div>
    <script async type="text/javascript" src="/js/bulma.js"></script>
    <script defer="" src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</body>

</html>
