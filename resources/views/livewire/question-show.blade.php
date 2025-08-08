<div>
    @foreach($questions as $question)
        <div>{{ $question->question }}</div>
    @endforeach

    <!-- Pagination Links -->
    <div>
        {{ $pagination->links() }}
    </div>
</div>
