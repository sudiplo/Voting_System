<x-top-layout>
    <div class="max-w-5xl mx-auto my-10 p-8 bg-white rounded-xl shadow-lg">
    <h1 class="text-3xl font-bold text-center text-blue-600 mb-8">
      Nepal Citizenship Card – Admin Entry
    </h1>

    <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">

      <!-- Full Name -->
      <div>
        <label class="block text-sm font-semibold text-gray-700">Full Name in Nepali</label>
        <input type="text" name="nepaliName"
          class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition" placeholder="नेपाली मा "
          required>
      </div>

      <!-- Full Name -->
      <div>
        <label class="block text-sm font-semibold text-gray-700">Full Name in English</label>
        <input type="text" name="nameEnglish"
          class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition" placeholder="In English"
          required>
      </div>

      <!-- Citizenship Number -->
      <div>
        <label class="block text-sm font-semibold text-gray-700">Citizenship Number</label>
        <input type="text" name="citizenshipNumber"
          class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition"
          required>
      </div>

      <!-- Father Name -->
      <div>
        <label class="block text-sm font-semibold text-gray-700">Father's Name</label>
        <input type="text" name="fatherName"
          class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition"
          required>
      </div>

      <!-- Mother Name -->
      <div>
        <label class="block text-sm font-semibold text-gray-700">Mother's Name</label>
        <input type="text" name="motherName"
          class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition"
          required>
      </div>

      <!-- Date of Birth -->
      <div>
        <label class="block text-sm font-semibold text-gray-700">Date of Birth</label>
        <input type="date" name="dob"
          class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition"
          required>
      </div>

      <!-- Gender -->
      <div>
        <label class="block text-sm font-semibold text-gray-700">Gender</label>
        <select name="gender"
          class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition"
          required>
          <option value="">Select Gender</option>
          <option>Male</option>
          <option>Female</option>
          <option>Other</option>
        </select>
      </div>

      <!-- Card Type -->
      <div>
        <label class="block text-sm font-semibold text-gray-700">Citizenship Card Type</label>
        <select name="cardType"
          class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition"
          required>
          <option value="">Select Card Type</option>
          <option>Citizenship by Birth</option>
          <option>Citizenship by Descent</option>
          <option>Naturalized Citizenship</option>
          <option>Honorary Citizenship</option>
        </select>
      </div>

      <!-- Address -->
      <div>
        <label class="block text-sm font-semibold text-gray-700">Permanent Address</label>
        <textarea name="address" rows="3"
          class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 hover:border-blue-500 transition"
          required></textarea>
      </div>

      <!-- Photo Upload -->
      <div>
        <label class="block text-sm font-semibold text-gray-700">Photo Upload</label>
        <input type="file" name="photo"
          class="w-full mt-2 p-3 border rounded-lg hover:border-blue-500 transition"
          required>
      </div>

      <!-- Submit Button -->
      <div class="md:col-span-2 text-center mt-4">
        <button type="submit"
          class="w-full md:w-1/3 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
          Save Citizenship Record
        </button>
      </div>

    </form>
  </div>

</x-top-layout>
