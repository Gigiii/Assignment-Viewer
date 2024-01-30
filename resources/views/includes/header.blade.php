
@if ($auth_data != Null)
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">
      <h2>
      Assignment Manager
      </h2>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse responsive-center-text" id="navbarText">
      <a class="nav-link text-secondary me-2" aria-current="page" href="/">Homepage</a>
      <span class="navbar-text ms-auto mr-2 text-light pe-3 fs-4">
        {{ $auth_data['role'] }}: {{ $auth_data['name'] }}
      </span>
      <form method="get" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-light responsive-btn">Log Out</button>
      </form>
    </div>
  </div>
</nav>
@else
<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="">Assignment Manager</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <span class="navbar-text ms-auto">
        Please Login To View Your Assignments
      </span>
    </div>
  </div>
</nav>
@endif