<footer class="bg-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-medium text-gray-900">About Us</h3>
                <p class="mt-4 text-sm text-gray-500">
                    We connect job seekers with employers in Japan, helping bridge the gap between talent and opportunity.
                </p>
            </div>
            
            <div>
                <h3 class="text-lg font-medium text-gray-900">Quick Links</h3>
                <ul class="mt-4 space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-900">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('terms') }}" class="text-sm text-gray-500 hover:text-gray-900">Terms of Service</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-sm text-gray-500 hover:text-gray-900">Contact Us</a>
                    </li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-lg font-medium text-gray-900">Contact</h3>
                <ul class="mt-4 space-y-2">
                    <li class="text-sm text-gray-500">Email: info@example.com</li>
                    <li class="text-sm text-gray-500">Phone: +81-XX-XXXX-XXXX</li>
                    <li class="text-sm text-gray-500">Address: Tokyo, Japan</li>
                </ul>
            </div>
        </div>
        
        <div class="mt-8 border-t border-gray-200 pt-8">
            <p class="text-sm text-gray-500 text-center">
                &copy; {{ date('Y') }} Job Portal. All rights reserved.
            </p>
        </div>
    </div>
</footer> 