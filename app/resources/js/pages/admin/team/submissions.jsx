import React from 'react';
import List from '@/layouts/admin/submission-list';
import { Stripe } from '@/layouts/admin/frame';

export default function Submissions({ team, submissions }) {
  return (
    <List submissions={ submissions }>
      <Stripe>Submissions by <span className="font-bold">{ team.name } ({ team.group })</span></Stripe>
    </List>
  )
}
