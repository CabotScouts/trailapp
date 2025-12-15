import React from 'react';
import List from '@/layouts/admin/submission-list';
import { Stripe } from '@/layouts/admin/frame';

export default function Submissions({ challenge, submissions }) {
  return (
    <List submissions={ submissions }>
      <Stripe>Submissions for <span className="font-bold">{ challenge }</span></Stripe>
    </List>
  )
}
