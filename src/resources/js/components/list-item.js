import React from 'react';
import { Link } from '@inertiajs/inertia-react';

export default function ListItem({ type, data }) {
  return (
    <Link href={ route(type, data.id) }>
      <div className="p-5 flex items-center border border-b-slate-500">
        <div className="flex-grow pr-5">
          <p className="text-medium text-lg text-slate-800">{ data.number && ( data.number + ' - ' ) }{ data.name }</p>
        </div>
        <div className="flex-none">
          <div className={`rounded-full text-center
              text-neutral-100 font-bold text-sm
              px-3 py-2 ${ data.accepted && 'bg-green-500'} ${ (!data.accepted && data.submitted) && 'bg-orange-500'} ${ !data.submitted && 'bg-red-500'}`}>
            <p>{ data.points }</p>
          </div>
        </div>
      </div>
    </Link>
  )
}
