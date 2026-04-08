@extends('layouts.app')
@section('content')
    {{-- URL Submission Form --}}
    <div class="card">
        <h2>Shorten a URL</h2>
        <form action="{{ route('links.store') }}" method="POST" class="shorten-form" style="display:flex; gap:.75rem;">
            @csrf

            <input type="url" name="original_url" placeholder="https://example.com/your-very-long-url-here" required
                class="url-input" />
            <button type="submit" class="btn-shorten">
                <i class="fa-solid fa-scissors" style="margin-right:.4rem;"></i>Shorten
            </button>
        </form>
        @error('original_url')
            <p class="error-msg"><i class="fa-solid fa-triangle-exclamation" style="margin-right:.3rem;"></i>{{ $message }}
            </p>
        @enderror
    </div>

    {{-- Links Table --}}
    @if ($links->count())
        <div class="table-card">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Original URL</th>
                            <th>Short Link</th>
                            <th>Clicks</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($links as $link)
                            <tr>
                                <td>
                                    <span class="original-url" title="{{ $link->original_url }}">
                                        {{ $link->original_url }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ url($link->short_code) }}" class="short-link" target="_blank"
                                        rel="noopener noreferrer">
                                        <i class="fa-solid fa-arrow-up-right-from-square"
                                            style="font-size:.7rem; margin-right:.3rem; opacity:.7;"></i>{{ url($link->short_code) }}
                                    </a>
                                </td>
                                <td>
                                    <span class="clicks-badge">
                                        <i class="fa-solid fa-chart-simple" style="font-size:.65rem;"></i>
                                        {{ $link->clicks }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('links.destroy', $link) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Mobile card list --}}
        <div class="mobile-links">
            @foreach ($links as $link)
                <div class="mobile-link-card">
                    <div class="mobile-link-header">
                        <a href="{{ url($link->short_code) }}" class="short-link" target="_blank" rel="noopener noreferrer">
                            <i class="fa-solid fa-arrow-up-right-from-square"
                                style="font-size:.65rem; margin-right:.25rem; opacity:.7;"></i>{{ url($link->short_code) }}
                        </a>
                        <form action="{{ route('links.destroy', $link) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                    <span class="original-url" title="{{ $link->original_url }}">{{ $link->original_url }}</span>
                    <div class="mobile-link-footer">
                        <span class="clicks-badge">
                            <i class="fa-solid fa-chart-simple" style="font-size:.65rem;"></i>
                            {{ $link->clicks }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fa-solid fa-link-slash"></i>
            No links yet — shorten your first URL above.
        </div>
    @endif
@endsection
