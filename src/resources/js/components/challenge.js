import React from 'react';
import { Link } from '@inertiajs/inertia-react';

export default function Challenge({ data }) {
  return (
    <Link href={ route('challenge', data.id) } preserveScroll>
      <div className="p-5 flex items-center border border-b-slate-500">
        <div className="flex-grow">
          <p className="text-medium text-lg text-slate-800">{ data.name }</p>
        </div>
        <div className="flex-none">
          <div className="bg-purple-500 rounded-full text-neutral-100 text-medium text-sm p-2">
            <p>{ data.points }</p>
          </div>
        </div>
      </div>
    </Link>
  )
}
