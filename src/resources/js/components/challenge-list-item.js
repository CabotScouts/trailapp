import React from 'react';
import { Link } from '@inertiajs/inertia-react';

export default function ChallengeListItem({ data }) {
  return (
    <Link preserveScroll href={ route('challenge', data.id) }>
      <div className="p-5 flex items-center border border-b-slate-500">
        <div className="flex-grow pr-5">
          <p className="text-medium text-lg text-slate-800">{ data.name }</p>
        </div>
        <div className="flex-none">
          <div className={`w-8 rounded-full text-center text-neutral-100 text-medium text-sm p-2 ${ data.submitted && 'bg-green-500'} ${ !data.submitted && 'bg-red-500'}`}>
            <p>{ data.points }</p>
          </div>
        </div>
      </div>
    </Link>
  )
}
