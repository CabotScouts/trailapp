import React from 'react';
import { Link } from '@inertiajs/react';
import { ArrowLeftIcon, ArrowRightIcon } from '@heroicons/react/solid';
import { __ } from '@/composables/translations';

export default function Paginator({ data }) {
  return (
    <div>
      {data.last_page > 1 && (
        <div className="bg-blue-600 text-neutral-100 text-lg lg:rounded-b-lg grid grid-cols-3 px-5 py-3">
          <div>{data.prev_page_url && (<Link href={data.prev_page_url}><ArrowLeftIcon className="w-6" /></Link>)}</div>
          <div className="text-center self-center">{__("current_page", { number: data.current_page })}</div>
          <div className="flex place-content-end">{data.next_page_url && (<Link href={data.next_page_url}><ArrowRightIcon className="w-6" /></Link>)}</div>
        </div>
      )}
    </div>
  )
}
