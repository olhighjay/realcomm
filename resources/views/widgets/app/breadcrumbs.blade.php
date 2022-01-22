<div class="breadcrumb-wrapper mt-4">
  <h1>{{ $page_title }}</h1>
  
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb p-0">
  <li class="breadcrumb-item">
  <a href="/">
  <span class="mdi mdi-home"></span>                
  </a>
  </li>
  @foreach ($crumbs as $key => $crumb)
  <li class="breadcrumb-item">
    <a @isset($urls) @if($key < count($crumbs)-1)href="{{ $urls[$crumb]}}" @endif @endisset>{{$crumb}}</a> 
    </li>
  @endforeach
  </ol>
  </nav>

</div>