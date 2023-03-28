<div class="main_menu border-top border-bottom">
    <div class="px-2 px-lg-4">
        <nav class="nav_menu">
            <ul class="d-flex justify-content-between main-menu align-items-center">
                @foreach (getCategories() as $key => $category)
                    <li><a href="{{ url('product?category_id='.$category->id) }}">{{ $category->category_name }}</a></li>
                @endforeach
            </ul>
        </nav>
    </div>
</div>
