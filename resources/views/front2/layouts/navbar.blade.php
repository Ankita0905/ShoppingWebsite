<?php $categories = categories(); ?>

@if(isset($categories) && count($categories) > 0)
<div class="side-menu animate-dropdown outer-bottom-xs">
    <div>
        <form action="{!! route('front') !!}" method="get">
            <div class="input-group">
                <input type="text" class="form-control" value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>" placeholder="Search" name="search">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">Go!</button>
                </span>
            </div>
        </form>
    </div>

    <div class="head" style="margin-top:20px;"><i class="icon fa fa-align-justify fa-fw"></i> 
        Categories
    </div>
    
    <nav class="yamm megamenu-horizontal">
        <ul class="nav">
            @foreach($categories as $category)
                <li>
                    <a href="{!! route('front', ['category' => $category->id]) !!}">
                        {!! $category->category_name !!}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</div>
@endif