import React from 'react';
import Frame from '@/layouts/admin/frame';
import ListItem from '@/components/admin/list-item';

export default function List({ challenges }) {
  return (
    <Frame title="Challenges">
      { challenges.map((c) => <ListItem key={ c.id } target={ route('view-challenge', c.id) }>
        <div className="flex-grow pr-5">
          <p className="text-xl text-medium">{ c.name }</p>
          <p className="text-sm">{ c.description }</p>
        </div>
        <div className="flex-none">
          <div className="w-8 rounded-full text-center text-neutral-100 text-medium text-sm p-2 bg-purple-600">
            <p>{ c.points }</p>
          </div>
        </div>
      </ListItem>) }
    </Frame>
  )
}
