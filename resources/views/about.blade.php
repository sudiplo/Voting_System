<x-defult_layout>

    <header class="w-full glass px-6 py-4 flex justify-between items-center shadow-xl">
        <div class="flex items-center gap-4">
            <a href="" class="text-xs text-gray-400">⌘ K</a>
            <a href="">about ></a>
            <a href="">next</a>
        </div>

        <div class="flex items-center gap-4">
            <button class="text-gray-600 hover:text-gray-800">
                ❓
            </button>

            <button class="text-gray-600 hover:text-gray-800">
                🔔
            </button>

    </header>
    
    <div class="max-w-5xl mx-auto my-10 p-8 bg-white rounded-xl shadow-lg">

        <!-- ================= HEADER ================= -->
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-gray-800">
                Mayor <span class="text-indigo-600">Registration</span>
            </h1>
            <p class="mt-2 text-gray-500">
                Official Mayor / Deputy Mayor Record
            </p>
        </div>

        <form action="" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <!-- Citizen ID -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Citizen ID</label>
                <input type="number" name="citizen_id"
                    class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition"
                    required>
            </div>

            <!-- District ID -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">District</label>
                <input type="number" name="district_id"
                    class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition"
                    required>
            </div>

            <!-- Palika ID -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Palika</label>
                <input type="number" name="palika_id"
                    class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition"
                    required>
            </div>

            <!-- Post -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Post</label>
                <select name="post"
                    class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition"
                    required>
                    <option value="">Select Post</option>
                    <option value="Mayor">Mayor</option>
                    <option value="Deputy Mayor">Deputy Mayor</option>
                </select>
            </div>

            <!-- Party -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700">Political Party</label>
                <textarea name="party" rows="3"
                    class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition"
                    placeholder="Enter party name"
                    required></textarea>
            </div>

            <!-- Goal -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700">
                    Vision / Goals
                </label>
                <textarea name="goal" rows="10"
                    class="w-full mt-2 p-4 border rounded-xl focus:ring-2 focus:ring-indigo-400 hover:border-indigo-500 transition"
                    placeholder="Write detailed vision, plans, and goals (paragraphs or pages)..."
                    required></textarea>
            </div>

            <!-- Submit Button -->
            <div class="md:col-span-2 text-center mt-6">
                <button type="submit"
                    class="w-full md:w-1/3 bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    Save Mayor Record
                </button>
            </div>

        </form>
    </div>

</x-defult_layout>
