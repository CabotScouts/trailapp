import React from 'react';
import { Link } from '@inertiajs/inertia-react';

export function ButtonBar({ children }) {
  return (
    <div className="p-3 flex justify-end bg-blue-600">
      { children }
    </div>
  );
}

export function Button({ href, children }) {
  return (
    <Link className="inline-flex items-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-blue-900 uppercase tracking-widest active:bg-white transition ease-in-out duration-150" href={ href }>{ children }</Link>
  )
}
