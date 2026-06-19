<nav class="navbar navbar-expand-sm bg-blue navbar-dark position-relative mt-3 shadow-warning">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="{{asset('images/logo.jfif')}}" height="80" class="rounded-circle position-absolute" style="top:-0.4em;"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse text-end" id="collapsibleNavbar" style="margin-left:5em;">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#">Dashboard</a>
        </li>
         <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Catalog</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="catalog">Add Book Information</a></li>
            <li><a class="dropdown-item" href="booklist">Update Book Information</a></li>
          </ul>
        </li>
       <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Manage</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Publisher</a></li>
            <li><a class="dropdown-item" href="#">Author</a></li>
            <li><a class="dropdown-item" href="#">Category</a></li>
          </ul>
        </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Circulation</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Borrow Book</a></li>
            <li><a class="dropdown-item" href="#">Return Book</a></li>
            <li><a class="dropdown-item" href="#">Reservation</a></li>
          </ul>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
         <button class="btn btn-sm btn-warning text-blue rounded-pill">Logout</button>
        </li>
       
      </ul>
    </div>
  </div>
</nav>