<?php

use App\Models\Link;

test('submitting a URL creates a short link and displays it', function () {
    $response = $this->post(route('links.store'), [
        'original_url' => 'https://example.com/some/very/long/url',
    ]);

    $response->assertRedirect(route('links.index'));
    $response->assertSessionHas('success');

    $link = Link::first();
    expect($link)->not->toBeNull();
    expect($link->original_url)->toBe('https://example.com/some/very/long/url');
    expect($link->short_code)->toHaveLength(6);
    expect($link->clicks)->toBe(0);

    $this->get(route('links.index'))
        ->assertSee(url($link->short_code));
});
