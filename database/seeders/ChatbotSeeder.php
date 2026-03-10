<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatCategory;
use App\Models\ChatFaq;

class ChatbotSeeder extends Seeder
{
   public function run(): void
{
    $this->call([
        ChatbotSeeder::class,
    ]);


        $refunds = ChatCategory::create(['title' => 'Refunds', 'sort_order' => 1]);
        $delivery = ChatCategory::create(['title' => 'Delivery', 'sort_order' => 2]);
        $Account = ChatCategory::create(['title' => 'Account', 'sort_order' => 3]);
        $Payment = ChatCategory::create(['title' => 'Payment', 'sort_order' => 4]);
        $Support = ChatCategory::create(['title' => 'Support', 'sort_order' => 5]);


        ChatFaq::create([
            'category_id' => $refunds->id,
            'question' => 'How long do refunds take?',
            'answer' => 'Refunds usually take 3–5 working days after approval.',
            'sort_order' => 1
        ]);

        ChatFaq::create([
            'category_id' => $refunds->id,
            'question' => 'Can I refund sale items?',
            'answer' => 'Sale items can be refunded within 14 days if unused and in original condition.',
            'sort_order' => 2
        ]);

        ChatFaq::create([
            'category_id' => $delivery->id,
            'question' => 'How long is delivery?',
            'answer' => 'Standard delivery takes 2–4 working days. Express delivery is next-day.',
            'sort_order' => 1
        ]);

                ChatFaq::create([
            'category_id' => $delivery->id,
            'question' => 'Do you deliver internationally?',
            'answer' => 'Yes, we deliver to most countries worldwide.',
            'sort_order' => 2   
        ]);


                ChatFaq::create([
            'category_id' => $Account->id,
            'question' => 'How do I reset my password?',
            'answer' => 'You can reset your password by clicking "Forgot Password" on the login page.',
            'sort_order' => 1
        ]);

                ChatFaq::create([
            'category_id' => $Account->id,
            'question' => 'How do I update my account information?',
            'answer' => 'You can update your account information in the "My Account" section.',
            'sort_order' => 2
        ]);



          ChatFaq::create([
            'category_id' => $Account->id,
            'question' => 'How do I update my account information?',
            'answer' => 'You can update your account information in the "My Account" section.',
            'sort_order' => 2
        ]);





          ChatFaq::create([
            'category_id' => $Payment->id,
            'question' => 'How do I update my payment information?',
            'answer' => 'You can update your payment information in the "My Account" section.',
            'sort_order' => 1
        ]);




          ChatFaq::create([
            'category_id' => $Payment->id,
            'question' => 'What payment methods do you accept?',
            'answer' => 'We accept all major credit cards, PayPal, and Apple Pay.',
            'sort_order' => 2
        ]);




          ChatFaq::create([
            'category_id' => $Payment->id,
            'question' => 'How do I cancel my payment?',
            'answer' => 'You can cancel your payment in the "My Account" section.',
            'sort_order' => 3
        ]);

        
          ChatFaq::create([
            'category_id' => $Payment->id,
            'question' => 'How do I cancel my payment?',
            'answer' => 'You can cancel your payment in the "My Account" section.',
            'sort_order' => 3
        ]);

         ChatFaq::create([
            'category_id' => $Support->id,
            'question' => 'How do I contact support?',
            'answer' => 'You can contact support via the "Contact Us" page or by emailing Tecci_Queries@net.com.',
            'sort_order' => 1
        ]); 

         ChatFaq::create([
            'category_id' => $Support->id,
            'question' => 'What are your support hours?',
            'answer' => 'Our support team is available Monday to Friday, 9 AM to 5 PM EST.',
            'sort_order' => 2
        ]); 
        
         ChatFaq::create([
            'category_id' => $Support->id,
            'question' => 'Do you offer live chat support?',
            'answer' => 'Yes, we offer live chat support during our support hours.',
            'sort_order' => 3
        ]);



    }
}