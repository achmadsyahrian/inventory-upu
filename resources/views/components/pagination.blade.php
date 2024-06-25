@props(['data'])

<div class="d-flex justify-content-between align-items-center">
   <div>
       Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries
   </div>
   <nav>
       <ul class="pagination mb-0">
           <li class="page-item {{ $data->previousPageUrl() ? '' : 'disabled' }}">
               <a class="page-link" href="{{ $data->previousPageUrl() ?? '#' }}" aria-label="Previous">
                   <span aria-hidden="true">&laquo;</span>
                   <span class="sr-only">Previous</span>
               </a>
           </li>
           @php
               $start = max(1, min($data->currentPage() - 2, $data->lastPage() - 4));
               $end = min($start + 4, $data->lastPage());
           @endphp
           @for ($i = $start; $i <= $end; $i++) 
               <li class="page-item {{ $i == $data->currentPage() ? 'active' : '' }}">
                   <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
               </li>
           @endfor
           <li class="page-item {{ $data->nextPageUrl() ? '' : 'disabled' }}">
               <a class="page-link" href="{{ $data->nextPageUrl() ?? '#' }}" aria-label="Next">
                   <span aria-hidden="true">&raquo;</span>
                   <span class="sr-only">Next</span>
               </a>
           </li>
       </ul>
   </nav>
</div>