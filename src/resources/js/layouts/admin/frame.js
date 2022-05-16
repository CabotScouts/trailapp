import React from 'react';
import { Head, Link } from '@inertiajs/inertia-react';
import { HomeIcon } from '@heroicons/react/solid'

export default function Frame({ page, children }) {
  return (
    <>
      <Head title="Dashboard" />
      <div className="min-h-screen bg-neutral-100">
        <div className="flex items-center px-5 py-4 bg-blue-900 shadow-sm">
          <div className="flex-grow pr-5">
            <p className="font-medium text-3xl font-serif text-neutral-50">{ page }</p>
          </div>
          <div className="flex-none">
            <Link href={ route('dashboard') }><HomeIcon className="w-8 text-neutral-50" /></Link>
          </div>
        </div>

        <div>
          { children }
        </div>
      </div>
    </>
  );
}
