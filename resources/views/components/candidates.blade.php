
    <!-- Dropdown Button -->
    <button id="candidateDropdownButton" data-dropdown-toggle="candidateDropdown" data-dropdown-trigger="hover" class="inline-flex items-center justify-center text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 shadow font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none" type="button">
        Select Candidate
        <svg class="w-4 h-4 ms-1.5" aria-hidden="true" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m19 9-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div id="candidateDropdown" class="z-10 hidden bg-white border border-gray-200 rounded-lg shadow-lg w-44">
        <ul class="p-2 text-sm font-medium text-gray-600"
            aria-labelledby="candidateDropdownButton">

            <li>
                <a href="{{ Route('Usermayor.view', ['id' => $ward->palika->id, 'e_id' => $e->id]) }}"
                class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                    Mayor
                </a>
            </li>

            <li>
                <a href="{{ Route('UserChairperson.view', ['id' =>$ward->id, 'e_id' => $e->id]) }}"
                class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                    Chairperson
                </a>
            </li>

            <li>
                <a href="{{ Route('UserMember.view', ['id' =>$ward->id, 'e_id' => $e->id]) }}"
                class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                    Member
                </a>
            </li>

            <li>
                <a href="{{ Route('candidateWonen.view', ['id' =>$ward->id, 'e_id' => $e->id]) }}"
                class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                    Women
                </a>
            </li>

            <li>
                <a href="{{ Route('candidateDalit.view', ['id' =>$ward->id, 'e_id' => $e->id]) }}"
                class="block px-4 py-2 rounded hover:bg-indigo-50 hover:text-indigo-600">
                    Dalit
                </a>
            </li>
        </ul>
    </div>
