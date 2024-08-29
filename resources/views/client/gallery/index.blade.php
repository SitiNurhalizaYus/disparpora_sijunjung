@extends('client.layouts.app')

@section('content')
<div class="container-fluid position-relative p-0">
    <!-- Header with logo and name -->
    <div class="container-fluid bg-primary py-5 bg-header">
        <div class="row py-5">
            <div class="col-12 pt-lg-5 mt-lg-5 text-center">
                <img src="{{ asset('/' . str_replace('/xxx/', '/100/', $setting['logo-parpora'])) }}" alt="Logo"
                    class="logo">
                <div class="logo-text">
                    <h3 class="text-light">{{ $setting['name-long'] }}</h3>
                    <p>Kabupaten Sijunjung</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Breadcrumbs -->
    <div class="container-fluid bg-primary py-3 bg-light">
        <div class="text-star px-5">
            <a href="{{ url('/beranda') }}" class="text-green">Beranda</a>
            <i class="bi bi-arrow-right-short text-green px-2"></i>
            <span class="text-green">Galeri</span>
        </div>
    </div>


    <!-- Videos Data -->
    @foreach($galleries as $gallery)
    <div class="aboutsection-video" id="about">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-6">
                <h2 class="px-5 text-dark">{{ $gallery['title'] }}</h2>
                <div class="description-container">
                </div>
            </div>
            <div class="col-md-6">
                <div class="video-container">
                    {!! $gallery['file_path'] !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

</div>


<script>
 function updateReadMoreButtons() {
    document.querySelectorAll('.description-container').forEach(container => {
        const btn = container.querySelector('.read-more-btn');
        const text = container.querySelector('.description-text');

        // Only show the "Read More" button if the description is too long
        if (text.scrollHeight > container.clientHeight) {
            btn.style.display = 'inline';
        } else {
            btn.style.display = 'none';
        }
    });
}

// Update the "Read More" buttons when the page loads
updateReadMoreButtons();

// Update the "Read More" buttons when the window is resized
window.addEventListener('resize', updateReadMoreButtons);

document.querySelectorAll('.description-container').forEach(container => {
    const btn = container.querySelector('.read-more-btn');
    btn.addEventListener('click', () => {
        container.classList.toggle('open');
        btn.textContent = container.classList.contains('open') ? 'Read Less' : 'Read More';
    });
});
</script>

@endsection
