import React from 'react';
import { Link, usePage } from '@inertiajs/inertia-react';

export default function ListFrame({ team, group, children, points }) {
  const { page, component } = usePage();
  
  return (
    <div className="min-h-screen flex flex-col">
      <div className="flex-none flex px-5 py-4 bg-purple-900 shadow-sm">
        <div className="flex-grow">
          <p className="font-medium text-3xl font-serif text-neutral-50">{ team }</p>
          <p className="text-sm text-neutral-100">{ group }</p>
        </div>
        <div className="flex-none flex items-center">
          <p className="text-sm p-2 bg-neutral-100 text-slate-900 font-bold rounded-full">{ points }</p>
        </div>
      </div>

      <div className="grow mb-16 overflow-auto bg-neutral-100">
        { children }
      </div>
      
      <div className="flex-none w-full fixed flex items-stretch bottom-0 h-16 font-bold text-xl text-slate-900">
        <Link href={ route('trail') } className={`flex-auto h-full ${ component === 'question/list' ? 'bg-slate-900' : 'bg-neutral-100' }`}>
          <div className={`h-full flex items-center ${ component === 'question/list' ? 'bg-neutral-100 rounded-b-lg' : 'bg-slate-900 rounded-tr-lg text-neutral-100' }`}>
            <div className="w-full text-center">Questions</div>
          </div>
        </Link>
        
        <Link href={ route('trail-challenges') } className={`flex-auto h-full ${ component === 'challenge/list' ? 'bg-slate-900' : 'bg-neutral-100' }`}>
        <div className={`h-full flex items-center ${ component === 'challenge/list' ? 'bg-neutral-100 rounded-b-lg' : 'bg-slate-900 rounded-tl-lg text-neutral-100' }`}>
          <div className="w-full text-center">Challenges</div>
        </div>
        </Link>
      </div>
    </div>
  );
}
