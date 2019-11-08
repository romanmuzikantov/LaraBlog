<?php

namespace Tests\Feature;

use App\BlogPost;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Comment;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsCreated()
    {
        $response = $this->get('/post');

        $response->assertStatus(200);
        $response->assertSeeText('No blog posts yet !');
    }

    public function testSee1BlogPostWhenThereIs1()
    {
        // Arrange
        $post = $this->createDummyBlogPost();

        // Act
        $response = $this->get('/post');

        // Assert
        $response->assertStatus(200);
        $response->assertSeeText($post->title);
        $response->assertSeeText($post->content);
        $response->assertDontSeeText('No blog posts yet !');

        $this->assertDatabaseHas('blog_posts', $post->toArray());
    }

    public function testStoreValid()
    {
        // Arrange
        $user = $this->user();

        $this->actingAs($user);

        $params = [
            'title' => 'This is a valid title',
            'content' => 'This is a valid content'
        ];

        // Act
        $response = $this->post('/post', $params);

        //Assert
        $response->assertStatus(302);
        $response->assertSessionHas('status');
        $this->assertEquals(session('status'), 'Blog post has been created!');
        $this->assertDatabaseHas('blog_posts', $params);
    }

    public function testStoreFail()
    {
        // Arrange
        $user = $this->user();

        $this->actingAs($user);

        $params = [
            'title' => 'x',
            'content' => 'x'

        ];

        // Act
        $response = $this->post('/post', $params);

        //Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertDatabaseMissing('blog_posts', $params);

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        // Arrange
        $user = $this->user();

        $this->actingAs($user);

        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', $post->toArray());

        // Act
        $params = [
            'title' => 'This is a new title',
            'content' => 'This is a new content'

        ];

        $response = $this->put("/post/{$post->id}", $params);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('status');
        $this->assertEquals(session('status'), 'Blog post was updated !');
        $this->assertDatabaseHas('blog_posts', $params);
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
    }

    public function testDeleteValid()
    {
        // Arrange
        $user = $this->user();

        $this->actingAs($user);

        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', $post->toArray());

        // Act
        $response = $this->delete("/post/{$post->id}");

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('status');
        $this->assertEquals(session('status'), 'Post was deleted!');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
    }

    public function testSeeCommentsWhenThereIs()
    {
        // Arrange
        $post = $this->createDummyBlogPost();

        // Act
        factory(Comment::class, 4)->create([
            'blog_post_id' => $post->id
        ]);

        $response = $this->get('/post');

        // Assert
        $response->assertSeeText('4 comments.');
    }

    private function createDummyBlogPost(): BlogPost
    {
        return factory(BlogPost::class)->states('title-test')->create();
    }
}
