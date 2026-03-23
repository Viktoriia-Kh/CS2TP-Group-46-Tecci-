<?php

namespace App\Http\Controllers;

use App\Models\ChatCategory;
use App\Models\ChatFaq;
use Illuminate\Http\JsonResponse;

class ChatbotController extends Controller
{
    // GET /chatbot/categories
    public function categories(): JsonResponse
    {
        $categories = ChatCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get(['id', 'title']);

        return response()->json($categories);
    }

    // GET /chatbot/categories/{category}/faqs
    public function faqsByCategory(ChatCategory $category): JsonResponse
    {
        if (!$category->is_active) {
            return response()->json(['message' => 'Category not available.'], 404);
        }

        $faqs = $category->faqs()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('question')
            ->get(['id', 'question']);

        return response()->json([
            'category' => ['id' => $category->id, 'title' => $category->title],
            'faqs' => $faqs,
        ]);
    }

    // GET /chatbot/faqs/{faq}
    public function faqAnswer(ChatFaq $faq): JsonResponse
    {
        if (!$faq->is_active) {
            return response()->json(['message' => 'FAQ not available.'], 404);
        }

        // If category was disabled, also block it.
        $faq->loadMissing('category:id,is_active,title');
        if (!$faq->category || !$faq->category->is_active) {
            return response()->json(['message' => 'FAQ not available.'], 404);
        }

        return response()->json([
            'id' => $faq->id,
            'question' => $faq->question,
            'answer' => $faq->answer,
            'category' => [
                'id' => $faq->category->id,
                'title' => $faq->category->title,
            ],
        ]);
    }
}
