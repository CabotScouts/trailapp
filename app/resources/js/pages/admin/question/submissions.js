import React from 'react';
import List from '@/layouts/admin/submission-list';
import { Stripe } from '@/layouts/admin/frame';

export default function Submissions({ question, submissions }) {
  return (
    <List submissions={ submissions }>
      <Stripe>Submissions for <span className="font-bold">{ question }</span></Stripe>
    </List>
  )
}
