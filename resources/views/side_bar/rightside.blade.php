<section>

    <ul class="list-group mb-5 mt-2">
        <li class="list-group-item active">最新記事</li>
        @if(isset($feeds))
        @foreach($feeds as $feed)
        <li class="list-group-item"><a href="{{ route('posts.show', ['id'=>$feed->id])}}" >{{ $feed->title }}</a></li>
        @endforeach
        @else
        <p>新着記事はありません。</p>
        @endif
    </ul>

    <ul class="list-group mb-5">
        <li class="list-group-item active">カテゴリ</li>
        @if($categories->count() > 0)
        @foreach($categories as $category)
        <li class="list-group-item">
            <a href="{{ route('category.single', ['id'=>$category->id]) }}">{{ $category->name }}</a>
        </li>
        @endforeach
        @else
        <p>現在、カテゴリは存在しません。</p>
        @endif
    </ul>

    <ul class="list-group">
        <li class="list-group-item active">アーカイブ</li>
        @if($archives_list->count() > 0)
        @foreach($archives_list as $archive)
        <li class="list-group-item">
            <a href="{{ route('archives', ['year'=>$archive->year, 'month' => $archive->month])  }}">
                {{ $archive->year }}年{{ $archive->month }}月
                <b class="badge">({{ $archive->post_count }}記事)</b>
            </a>
         </li>
        @endforeach
        @else
        <p>アーカイブはありません。</p>
        @endif
    </ul>
</section>
