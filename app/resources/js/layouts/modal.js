import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import { XIcon } from '@heroicons/react/solid';

export function Modal({ children, back=false }) {

  const goBack = (e) => {
    if(!back) {
      e.preventDefault();
      history.back();
    }
  };

  return (
    <div className="flex">
      <div className="p-4 absolute top-0 right-0">
        <Link href={ back } onClick={ goBack }>
          <XIcon className="w-10 h-10 text-slate-300" />
        </Link>
      </div>
      <div className="w-full">
        { children }
      </div>
    </div>
  );
}

export function Header({ data }) {
  return (
    <div className="p-10 pb-5 text-neutral-50">
      <div className="pt-5 font-serif text-4xl font-bold">{ data.number && (data.number + ' - ') }{ data.name }</div>
      { (data.points > 0) && (<div className="text-neutral-100">{ data.points } points</div>) }
      { data.description && <div className="text-lg font-medium mt-5">{ data.description }</div> }
      { data.question && <div className="text-lg font-medium mt-5 italic">{ data.question }</div> }
    </div>
  )
}
