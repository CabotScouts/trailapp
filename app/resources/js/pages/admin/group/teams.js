import React from 'react';
import Frame, { Stripe } from '@/layouts/admin/frame';
import List from '@/layouts/admin/team-list';

export default function TeamList({ teams, group }) {
  return (
    <List teams={ teams }>
      Teams in <span className="font-bold">{ group }</span>
    </List>
  )
}
