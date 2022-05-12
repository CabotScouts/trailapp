import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import { XIcon } from '@heroicons/react/solid';

export default function Frame(props) {
  return (
    <div className="flex">
      <div className="p-4 absolute top-0 right-0">
        <Link href={ route('trail') }><XIcon className="w-10 h-10 text-slate-300" /></Link>
      </div>
      { props.children }
    </div>
  );
}
