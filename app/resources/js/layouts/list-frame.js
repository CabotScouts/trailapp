import React from 'react';
import { Link, usePage } from '@inertiajs/inertia-react';
import { QrcodeIcon } from '@heroicons/react/solid';

export default function ListFrame({ team, group, points, children }) {
  const { page, component } = usePage();

  // <p className="text-sm px-3 py-2 bg-neutral-100 text-slate-900 font-bold rounded-full">{ points }</p>

  return (
    <div className="min-h-screen flex flex-col">
      <div className="flex-none flex px-5 py-4 bg-purple-900 shadow-sm">
        <div className="flex-grow">
          <p className="font-medium text-3xl font-serif text-neutral-50">{ team.name }</p>
          <p className="text-sm text-neutral-100">{ group }</p>
        </div>
        <div className="flex-none flex items-center">
        <Link href={ route('show-qr') } className="w-10 mr-1 rounded-xl text-center text-purple-900 font-bold text-sm p-1 bg-white">
          <QrcodeIcon />
        </Link>
        </div>
      </div>

      <div className="grow mb-14 overflow-auto bg-neutral-100">
        { children }
      </div>
      
      <div className="flex-none w-full fixed flex items-stretch bottom-0 h-14 font-medium font-serif text-xl text-purple-900">
        <Link href={ route('trail') } className={`flex-auto h-full ${ component === 'question/list' ? 'bg-slate-900' : 'bg-neutral-100' }`} preserveScroll>
          <div className={`h-full flex items-center ${ component === 'question/list' ? 'bg-neutral-100 rounded-b-lg' : 'bg-slate-900 rounded-tr-lg text-neutral-100' }`}>
            <div className="w-full text-center">Questions</div>
          </div>
        </Link>
        
        <Link href={ route('trail-challenges') } className={`flex-auto h-full ${ component === 'challenge/list' ? 'bg-slate-900' : 'bg-neutral-100' }`} preserveScroll>
        <div className={`h-full flex items-center ${ component === 'challenge/list' ? 'bg-neutral-100 rounded-b-lg' : 'bg-slate-900 rounded-tl-lg text-neutral-100' }`}>
          <div className="w-full text-center">Challenges</div>
        </div>
        </Link>
      </div>
    </div>
  );
}
